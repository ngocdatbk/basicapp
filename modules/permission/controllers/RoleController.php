<?php

namespace app\modules\permission\controllers;

use Yii;
use app\modules\permission\models\AuthItem;
use app\modules\permission\models\AuthAssignment;
use app\modules\permission\models\AuthItemChild;
use app\modules\permission\models\AuthItemSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use yii\db\Exception;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * RoleController implements the CRUD actions for AuthItem model.
 */
class RoleController extends Controller
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
                        'roles' => ['Role'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['CreateRole'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['UpdateRole'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['DeleteRole'],
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,Item::TYPE_ROLE);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssignPermission($id)
    {
        $model = $this->findModel($id);
        $listPermission = $model->listPermissionWithAssigned();

        if (Yii::$app->request->post()) {
            $new_permission = array_keys(Yii::$app->request->post('permission'));
            $old_permission = AuthItemChild::find()
                ->innerJoin(AuthItem::tableName(),'auth_item.name = auth_item_child.child')
                ->select(['child','parent'])
                ->where(['type' => 2, 'parent' => $model->name])
                ->asArray()
                ->column();

            $insert_permission = array_diff($new_permission, $old_permission);
            $delete_permission = array_diff($old_permission, $new_permission);

            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                if ($insert_permission) {
                    $rows = [];
                    foreach ($insert_permission as $cid => $child) {
                        $rows[] = ['parent' => $model->name, 'child' => $child];
                    }
                    Yii::$app->db->createCommand()->batchInsert(AuthItemChild::tableName(), ['parent', 'child'], $rows)->execute();
                }
                if ($delete_permission)
                    AuthItemChild::deleteAll(['parent' => $model->name, 'child' => $delete_permission]);
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->name]);
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $listPermission,
            'pagination' => false
        ]);
        return $this->render('assign_permission', [
            'model' => $model,
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
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post())) {
            $model->type = Item::TYPE_ROLE;
            $model->created_at = time();
            $model->updated_at = time();
            if($model->save())
                return $this->redirect(['assign-permission', 'id' => $model->name]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $model = $this->findModel($id);
        $old_name = $model->name;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $model->updated_at = time();
                $model->save();
                if ($old_name != $model->name) {
                    AuthItemChild::updateAll(["parent" => $model->name], ["parent" => $old_name]);
                    AuthItemChild::updateAll(["child" => $model->name], ["child" => $old_name]);
                    AuthAssignment::updateAll(["item_name" => $model->name], ["item_name" => $old_name]);
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->name]);
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getName());
                $transaction->rollBack();
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
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
