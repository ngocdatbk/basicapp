<?php

namespace app\modules\permission\controllers;

use Yii;
use app\modules\permission\models\AuthRule;
use app\modules\permission\models\EditRule;
use app\modules\permission\models\AuthItem;
use yii\data\ActiveDataProvider;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RuleController implements the CRUD actions for AuthRule model.
 */
class RuleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['Rule'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['CreateRule'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['UpdateRule'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['DeleteRule'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthRule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthRule::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthRule model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EditRule();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $rule = new $model->class;
            if($auth->add($rule))
                return $this->redirect(['view', 'id' => $rule->name]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthRule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $editModel = new EditRule();
        $object = unserialize($model->data);
        $editModel->class = get_class($object);

        if ($editModel->load(Yii::$app->request->post()) && $editModel->validate()) {
            $auth = Yii::$app->authManager;
            $rule = new $editModel->class;
            if($auth->update($rule->name, $rule))
                return $this->redirect(['view', 'id' => $rule->name]);
        }

        return $this->render('update', [
            'editModel' => $editModel,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthRule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (AuthItem::find()->where(['rule_name' => $id])->all()) {
            Yii::$app->session->setFlash('error', 'Rule have been assigned to permission!');
        } else
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthRule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
