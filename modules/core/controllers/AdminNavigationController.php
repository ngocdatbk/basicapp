<?php

namespace app\modules\core\controllers;

use app\components\Controller;
use app\modules\core\models\AdminNavigation;
use app\modules\permission\models\AuthItem;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\Exception;

/**
 * AdminNavigationController implements the CRUD actions for AdminNavigation model.
 */
class AdminNavigationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        if(!YII_ENV_DEV && (!defined('YII_DEBUG') || (defined('YII_DEBUG') && !YII_DEBUG))) {
            $this->responseBadRequest();
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all AdminNavigation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $condition = [];

        if (Yii::$app->request->get() && !empty(Yii::$app->request->get('group'))) {
            $group = Yii::$app->request->get('group');
            $condition['menu_group'] = $group;
        } else {
            $group = '';
        }

        $allMenuItems = AdminNavigation::find()->where($condition)->orderBy(['menu_group' => SORT_DESC, 'display_order' => SORT_ASC, 'created_date' => SORT_ASC])->all();

        return $this->render('index', [
            'listItems' => AdminNavigation::buildMenuItems($allMenuItems),
            'group' => $group,
        ]);
    }

    /**
     * Displays a single AdminNavigation model.
     * @param resource $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdminNavigation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminNavigation();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $model->save();
                $model_before = $this->findModel($model->display_before);
                if ($model->display_order < $model_before->display_order) {
                    AdminNavigation::updateAllCounters(
                        ['display_order' => -1],
                        [
                            'AND',
                            ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id],
                            ['>', 'display_order', $model->display_order],
                            ['<', 'display_order', $model_before->display_order]
                        ]
                    );
                    $model->display_order = $model_before->display_order;
                    $model->save();
                } elseif ($model->display_order > $model_before->display_order) {
                    AdminNavigation::updateAllCounters(
                        ['display_order' => 1],
                        [
                            'AND',
                            ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id],
                            ['>=', 'display_order', $model_before->display_order],
                            ['<', 'display_order', $model->display_order]
                        ]
                    );
                    $model->display_order = $model_before->display_order;
                    $model->save();
                }
                $transaction->commit();
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        $authItem = new AuthItem();
        $permission = $authItem->listPermissionTree('input');
        return $this->render('create', [
            'model' => $model,
            'permission' => $permission
        ]);
    }

    /**
     * Updates an existing AdminNavigation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param resource $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $afterItem = AdminNavigation::find()
            ->where(['AND', ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id], ['>', 'display_order', $model->display_order]])
            ->orderBy(['display_order' => SORT_ASC])
            ->one();
        if ($afterItem)
            $model->display_before = $afterItem->navigation_id;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                unset($model->display_order);
                $model->save();
                if ($model->display_before) {
                    $model_before = $this->findModel($model->display_before);
                    if ($model->display_order < $model_before->display_order) {
                        AdminNavigation::updateAllCounters(
                            ['display_order' => -1],
                            [
                                'AND',
                                ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id],
                                ['>=', 'display_order', $model->display_order],
                                ['<=', 'display_order', $model_before->display_order],
                                ['!=', 'navigation_id', $model->navigation_id],
                                ['!=', 'navigation_id', $model_before->navigation_id]

                            ]
                        );
                        $model->display_order = $model_before->display_order;
                        $model->save();
                    } elseif ($model->display_order > $model_before->display_order) {
                        AdminNavigation::updateAllCounters(
                            ['display_order' => 1],
                            [
                                'AND',
                                ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id],
                                ['>=', 'display_order', $model_before->display_order],
                                ['<=', 'display_order', $model->display_order],
                                ['!=', 'navigation_id', $model->navigation_id]
                            ]
                        );
                        $model->display_order = $model_before->display_order;
                        $model->save();
                    } else {
                        AdminNavigation::updateAllCounters(
                            ['display_order' => 1],
                            [
                                'AND',
                                ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id],
                                ['>=', 'display_order', $model_before->display_order],
                                ['!=', 'navigation_id', $model->navigation_id]
                            ]
                        );
                    }
                } else {
                    $maxOrder = AdminNavigation::find()
                        ->where(['AND', ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id], ['!=', 'navigation_id', $model->navigation_id]])
                        ->orderBy(['display_order' => SORT_DESC])
                        ->one();
                    $model->display_order = $maxOrder ? ($maxOrder->display_order + 1) : 1;
//                    echo $model->display_order;
//                    $transaction->rollBack();
//                    exit();
                    $model->save();
                }


                $transaction->commit();
                Yii::$app->session->setFlash('highlight', $id);
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        $authItem = new AuthItem();
        $permission = $authItem->listPermissionTree('input');

        return $this->render('update', [
            'model' => $model,
            'permission' => $permission
        ]);
    }

    /**
     * Deletes an existing AdminNavigation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param resource $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionClearCache()
    {
        if (Yii::$app->cache) {
            if (Yii::$app->cache->get('menu_header_menu')) {
                Yii::$app->cache->delete('menu_header_menu');
            }

            if (Yii::$app->cache->get('menu_sidebar_menu')) {
                Yii::$app->cache->delete('menu_sidebar_menu');
            }

            Yii::$app->session->setFlash('success', 'Deleted cache successfully');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the AdminNavigation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param resource $id
     * @return AdminNavigation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminNavigation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionToggleDisplay($id)
    {
        $model = AdminNavigation::find()->where(['navigation_id' => $id])->one();

        if ($model !== null) {
            $model->updateAttributes(['display_f' => $model->display_f ? 0 : 1]);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->responseBadRequest();
    }

    public function actionChangeOrder($id, $type)
    {
        $model = $this->findModel($id);

        if ($type == 'up') {
            $changeItems = AdminNavigation::find()
                ->where(['AND', ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id], ['<', 'display_order', $model->display_order]])
                ->orderBy(['display_order' => SORT_DESC])
                ->one();
        } else {
            $changeItems = AdminNavigation::find()
                ->where(['AND', ['menu_group' => $model->menu_group, 'parent_id' => $model->parent_id], ['>', 'display_order', $model->display_order]])
                ->orderBy(['display_order' => SORT_ASC])
                ->one();
        }

        if ($changeItems !== null) {
            $currentOrder = $model->display_order;
            $model->display_order = $changeItems->display_order;
            $changeItems->display_order = $currentOrder;

            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                $changeItems->save(false, ['display_order']);
                $model->save(false, ['display_order']);
                $transaction->commit();
                Yii::$app->session->setFlash('highlight', $id);
                Yii::$app->session->setFlash('success', 'Successfully');
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $model->errors);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionListMenuParent($group, $q ='', $id='')
    {
        $model = new AdminNavigation();
        $array_id = $id ? [$id => $id] : [];
        $data = $model->getAdminMenuOptions($q, $group, $array_id);
        $out['results'] = array_values($data);

        return $this->responseJSON($out);
    }

    public function actionListMenuChild($parent_id)
    {
        $model = new AdminNavigation();
        $data = $model->getAdminMenuChilds($parent_id);
        $out['results'] = array_values($data);

        return $this->responseJSON($out);
    }
}
