<?php

namespace app\modules\permission\controllers;

use Yii;
use app\modules\permission\models\AuthItem;
use app\modules\permission\models\AuthRule;
use app\modules\permission\models\CreatePermissionForm;
use app\modules\permission\models\AuthAssignment;
use app\modules\permission\models\AuthItemChild;
use app\modules\permission\models\AuthItemSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use yii\db\Exception;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * PermissionController implements the CRUD actions for AuthItem model.
 */
class PermissionController extends Controller
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
                        'roles' => ['Permission'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['CreatePermission'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['UpdatePermission'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['DeletePermission'],
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

    public function actionViewAs($id = 0)
    {
        if ($id === 0) {
            if (!Yii::$app->user->can('viesAsPermisson')) {
                throw new ForbiddenHttpException(Yii::t('permission.global', 'You can not access this feature.'));
            }

            Yii::$app->session->set('loggedUserId', Yii::$app->user->id);

            $viewAsData = Yii::$app->dataRegistry->get('viewAsUser');
            $viewAsData[Yii::$app->user->id] = [
                'loggedUserId' => Yii::$app->user->id,
            ];

            Yii::$app->dataRegistry->set('viewAsUser', $viewAsData);
        }

        if (!Yii::$app->session->get('loggedUserId')) {
            throw new ForbiddenHttpException(Yii::t('permission.global', 'You can not access this feature.'));
        }

        $loggedUserId = Yii::$app->session->get('loggedUserId');

        if ($id && $loggedUserId) {
            $viewAsData = Yii::$app->dataRegistry->get('viewAsUser');

            if (empty($viewAsData) || !isset($viewAsData[$loggedUserId])) {
                $viewAsData[$loggedUserId] = [
                    'loggedUserId' => $loggedUserId,
                ];
            }

            $viewAsData[$loggedUserId]['viewAsUserId'] = $id;

            Yii::$app->dataRegistry->set('viewAsUser', $viewAsData);
        }

        $loginRedirect = \app\helpers\ArrayHelper::getValue(Yii::$app->params, 'loginRedirect');

        return !empty($loginRedirect) ? $this->redirect($loginRedirect) : $this->goHome();
    }

    public function actionReset($redirect = '')
    {
        $loggedUserId = Yii::$app->session->get('loggedUserId');
        $viewAsData = Yii::$app->dataRegistry->get('viewAsUser');
        $redirect = !empty($redirect) ? $redirect : Yii::$app->request->referrer;

        if(isset($viewAsData[$loggedUserId])) {
            unset($viewAsData[$loggedUserId]);
        }

        if(!empty($viewAsData)) {
            Yii::$app->dataRegistry->set('viewAsUser', $viewAsData);
        } else {
            Yii::$app->dataRegistry->delete('viewAsUser');
        }

        Yii::$app->session->set('loggedUserId', null);

        return !empty($redirect) ? $this->redirect($redirect) : $this->goHome();
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new AuthItem();
        $listPermission = $model->listPermissionTree('list');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $listPermission,
            'pagination' => false
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
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
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreatePermissionForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->createPermission())
                return $this->redirect(['view', 'id' => $model->name]);
        }

        $parents = $model->listPermissionTree('input');
        $rules = AuthRule::find()->indexBy('name')->column();

        return $this->render('create', [
            'model' => $model,
            'parents' => $parents,
            'rules' => $rules
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = CreatePermissionForm::findOne($id);
        $model->parent = $model->parents ? $model->parents[0]->name : '';
        $old_name = $model->name;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->updatePermission($old_name))
                return $this->redirect(['view', 'id' => $model->name]);
        }

        $parents = $model->listPermissionTree('input', [$old_name => $old_name]);
        $rules = AuthRule::find()->indexBy('name')->column();
        return $this->render('update', [
            'model' => $model,
            'parents' => $parents,
            'rules' => $rules
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->getDb()->beginTransaction();

        try {
            AuthItemChild::deleteAll("parent='".$model->name."' or child='".$model->name."'");
            AuthAssignment::deleteAll("item_name='".$model->name."'");
            $model->delete();
            $transaction->commit();
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getName());
            $transaction->rollBack();
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    public function actionListPermission()
    {
        $q = Yii::$app->request->get('q');
        $query = new \yii\db\Query;
        $query->select('permission_id as id, title as text')
            ->from(Permission::tableName())
            ->limit(20);

        if (!empty($q)) {
            $query->andWhere(['like', 'title', trim($q)]);
        }

        $command = $query->createCommand();
        $data = $command->queryAll();

        $out['results'] = array_values($data);

        return $this->responseJSON($out);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
