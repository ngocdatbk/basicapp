<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\user\models\User;
use app\modules\user\models\UserAuth;
use app\modules\user\models\UserConfirm;
use app\modules\user\models\form\ForgotPasswordForm;
use app\modules\user\models\form\LoginForm;
use app\modules\user\models\form\ResetPassword;
use app\modules\user\models\form\SignupForm;

use yii\helpers\ArrayHelper;
use app\helpers\MailHelper;
use app\helpers\StringHelper;
use yii\web\NotFoundHttpException;

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
            'login-facebook' => [
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
        return $this->redirect('/dashboard');

//        return $this->goHome();
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
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect('/dashboard');
                }
            }
        }

        return $this->render('signup', [
            'model' => $model
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

    /**
     * Forgot password
     */
    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new ForgotPasswordForm();

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post('ForgotPasswordForm');
            $user = User::findByEmail($data['email']);
            $isError = false;
            $transaction = Yii::$app->getDb()->beginTransaction();

            if (!$user) {
                $isError = true;
                Yii::$app->getSession()->setFlash('error', Yii::t('user.field', 'Your email does not exist.'));
            }

            if (!$isError) {
                $userConfirm = UserConfirm::findOne(['email' => $data['email']]);
                $security = new \yii\base\Security();

                if (!$userConfirm) {
                    $userConfirm = new UserConfirm();
                    $userConfirm->user_id = $user->user_id;
                    $userConfirm->email = $data['email'];
                }

                $userConfirm->confirm_key = $security->generateRandomString(32);
                $userConfirm->created_at = time();

                if (!$userConfirm->save()) {
                    $isError = true;
                    Yii::$app->getSession()->setFlash('error', $userConfirm->getErrors());
                }
            }

            if (!$isError) {
                if (!$this->_sendConfirmEmail($user, $userConfirm->confirm_key)) {
                    $isError = true;
                    Yii::$app->getSession()->setFlash('error', Yii::t('user.field', 'Can not send email'));
                }
            }

            if ($isError) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
                Yii::$app->getSession()->setFlash('success', Yii::t('user.field', 'Request password has been sent. Please check your email to get new password.'));
                return $this->redirect('forgot-password');
            }
        }

        return $this->render('forgot-password', ['model' => $model]);
    }

    public function actionGetNewPassword($confirm_key)
    {
        $confirmModel = UserConfirm::findOne(['confirm_key' => $confirm_key]);

        if (empty($confirmModel)) {
            throw new NotFoundHttpException(Yii::t('user.field', 'Your confirm key does not exist or expired'));
        }

        $user = User::findByEmail($confirmModel->email);

        if (!$user) {
            throw new NotFoundHttpException(Yii::t('user.field', 'Your email does not exist.'));
        }

        $newPassword = StringHelper::generateRandomString(12);

        $userAuth = UserAuth::findOne($user->user_id);

        if (!$userAuth) {
            $userAuth = new UserAuth();
            $userAuth->user_id = $user->user_id;
            $userAuth->generateAuthKey();
        }

        $userAuth->setPassword($newPassword);

        $isError = false;
        $transaction = Yii::$app->getDb()->beginTransaction();

        if (!$userAuth->save()) {
            $isError = true;
            Yii::$app->getSession()->setFlash('error', $userAuth->getErrors());
        }

        if (!$isError) {
            if (!$confirmModel->delete()) {
                $isError = true;
                Yii::$app->getSession()->setFlash('error', $confirmModel->getErrors());
            }
        }

        if (!$isError) {
            if (!$this->_sendEmailNewPassword($user, $newPassword)) {
                $isError = true;
                Yii::$app->getSession()->setFlash('error', Yii::t('user.messages', 'Can not send email'));
            }
        }

        if ($isError) {
            $transaction->rollBack();
        } else {
            $transaction->commit();
        }

        return $this->render('get-new-password', [
            'user' => $user,
            'isError' => $isError,
        ]);
    }

    protected function _sendEmailNewPassword($user, $password)
    {
        return \app\modules\email\models\EmailQueue::queue('mailer_marketing', $user->email, 'New password', $this->module->id, 'send_new_password', ['fullname' => $user->fullname, 'user_id' => $user->user_id, 'password' => $password],null);
    }

    /**
     * Send a confirm request password email to user
     * @param type $user
     * @return boolean
     */
    protected function _sendConfirmEmail($user, $confirmKey)
    {
        return \app\modules\email\models\EmailQueue::queue('mailer_marketing', $user->email, 'Confirm reset password', $this->module->id, 'forgot_password', ['fullname' => $user->fullname, 'confirm_key' => $confirmKey],null);
    }

    /**
     * Reset password
     */
    public function actionResetPassword()
    {
        $model = new ResetPassword();
        $confirm_key = Yii::$app->request->get('confirm_key');

        $confirmModel = UserConfirm::findOne(['confirm_key' => $confirm_key]);

        if (empty($confirmModel)) {
            throw new NotFoundHttpException(Yii::t('user.field', 'Your confirm key does not exist or expired'));
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //$confirmModel = UserConfirm::fiUserConfirmndOne(['confirm_key' => $model->confirm_key]);

                if (!$confirmModel) {
                    Yii::$app->getSession()->setFlash('warning', Yii::t('user.field', 'Your confirm key does not exist or expired'));
                    return $this->render('reset-password', ['model' => $model]);
                }

                $user = User::findByEmail($confirmModel->email);

                if (!$user) {
                    Yii::$app->getSession()->setFlash('warning', Yii::t('user.field', 'Your email does not exist.'));
                    return $this->render('reset-password', ['model' => $model]);
                }

                $userAuth = UserAuth::findOne($user->user_id);

                if (!$userAuth) {
                    $userAuth = new UserAuth();
                    $userAuth->user_id = $user->user_id;
                    $userAuth->generateAuthKey();
                }

                $userAuth->setPassword($model->password);

                if ($userAuth->save(false)) {
                    if ($confirmModel->delete()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('user.field', 'Password reset successfully.'));
                        return $this->redirect(['/user/auth/login']);
                    }
                }
            }

            Yii::$app->getSession()->setFlash('warning', Yii::t('user.field', 'Your request is temporarily unable to be processed. Please contact support for further assistance.'));
        }

        return $this->render('reset-password', ['model' => $model]);
    }
}
