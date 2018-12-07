<?php

namespace app\modules\permission\controllers;

use Yii;
use app\modules\permission\models\AuthItem;
use app\modules\permission\models\AuthAssignment;
use app\modules\permission\models\AuthItemChild;
use app\modules\permission\models\AuthItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use yii\db\Exception;

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
                return $this->redirect(['view', 'id' => $model->name]);
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
