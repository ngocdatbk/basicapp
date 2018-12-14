<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\models\form\CreateForm;
use app\modules\user\models\form\UpdateForm;
use app\modules\permission\models\AuthItem;
use app\modules\permission\models\AuthAssignment;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->roles = implode(', ', $model->roles);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionViewPermission($id)
    {
        $model = $this->findModel($id);

        $authItem = new AuthItem();
        $listPermission = $authItem->listPermissionOfUser($id);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $listPermission,
            'pagination' => false
        ]);
        return $this->render('view_permission', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateForm();
        $model->is_active = 1;

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->create()) {
                return $this->redirect(['view', 'id' => $user->user_id]);
            } else
                Yii::$app->session->setFlash('error', Yii::t('user.field', 'Error'));
        }

        $all_roles = AuthItem::find()->select(['description', 'name'])->where(['type' => 1])->indexBy('name')->column();
        return $this->render('create', [
            'model' => $model,
            'all_roles' => $all_roles
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = UpdateForm::findModel($id);
        $old_roles = $model->roles;

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            if ($model->updateUser($old_roles)) {
                Yii::$app->session->setFlash('success', Yii::t('user.field', 'Updated successfully.'));
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user.field', 'Updated fail.'));
            }
        }

        $all_roles = AuthItem::find()->select(['description', 'name'])->where(['type' => 1])->indexBy('name')->column();
        return $this->render('update', [
            'model' => $model,
            'all_roles' => $all_roles
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteUser();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            $model->roles = AuthAssignment::find()->where(['user_id' => $model->user_id])->column();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
