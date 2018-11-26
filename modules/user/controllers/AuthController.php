<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\user\models\User;

use app\modules\user\models\form\LoginForm;
use yii\helpers\ArrayHelper;

class AuthController extends \yii\web\Controller
{
    public $layout = 'auth';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'login-google' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'actionAuthSuccess'],
            ],
        ];
    }

    public function actionAuthSuccess($client)
    {
        try {
            $attributes = $client->getUserAttributes();
            $email = ArrayHelper::getValue($attributes, 'emails')[0]['value'];
        } catch (Exception $exc) {
            Yii::$app->getSession()->setFlash('error', Yii::t('user.message', 'Authentication error.'));
            return $this->redirect(['/user/auth/login']);
        }

        if (empty($email)) {
            Yii::$app->getSession()->setFlash('error', Yii::t('user.message', 'Authentication error.'));
            return $this->redirect(['/user/auth/login']);
        }

        $user = User::findOne(['email' => $email]);

        if ($user === null) {
            Yii::$app->getSession()->setFlash('error', Yii::t('user.message', 'Your email does not exist.'));
            return $this->redirect(['/user/auth/login', 'model' => $user]);
        }

        Yii::$app->getUser()->login($user);

        return $this->goHome();
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
