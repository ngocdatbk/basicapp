<?php

namespace app\modules\cronjob\controllers;

use Yii;
use yii\helpers\Json;
use app\modules\cronjob\models\Cronjob;
use app\modules\cronjob\models\search\CronjobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\cronjob\helpers\CronHelper;

/**
 * CronjobController implements the CRUD actions for Cronjob model.
 */
class CronjobController extends Controller
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
     * Lists all Cronjob models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CronjobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cronjob model.
     * @param integer $id
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
     * Creates a new Cronjob model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CronJob();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();

            $dayType = isset($data['day_type']) ? $data['day_type'] : 'dow';

            $runRules = [
                'minutes' => $data['minute'],
                'hours' => $data['hour'],
                'day_type' => $dayType,
                $dayType => ($dayType == 'dow') ? $data['dayOfWeek'] : $data['dayOfMonth']
            ];

            $model->setAttributes([
                'run_rules' => Json::encode($runRules),
                'next_run' => CronHelper::calculateNextRunTime($runRules),
                'is_active' => isset($data['is_active']) ? intval($data['is_active']) : 0,
            ]);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->is_active = 1;
        $model->logging_f = 1;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cronjob model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();

            $dayType = isset($data['day_type']) ? $data['day_type'] : 'dow';

            $runRules = [
                'minutes' => $data['minute'],
                'hours' => $data['hour'],
                'day_type' => $dayType,
                $dayType => ($dayType == 'dow') ? $data['dayOfWeek'] : $data['dayOfMonth']
            ];

            $model->setAttributes(array(
                'run_rules' => Json::encode($runRules),
                'next_run' => CronHelper::calculateNextRunTime($runRules),
                'is_active' => isset($data['is_active']) ? intval($data['is_active']) : 0,
                'logging_f' => isset($data['logging_f']) ? intval($data['logging_f']) : 0,
            ));

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cronjob model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionChangeActiveStatus($id)
    {
        $model = $this->findModel($id);

        $model->is_active = intval(!$model->is_active);

        if ($model->save(true, ['is_active'])) {
            Yii::$app->session->setFlash('success', Yii::t('cronjob.global', 'Update successfully'));
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('cronjob.global', 'Update failed'));
        }

        return $this->redirect(['index']);
    }

    public function actionChangeLoggingStatus($id)
    {
        $model = $this->findModel($id);

        $model->logging_f = intval(!$model->logging_f);

        if (!$model->save(true, ['logging_f'])) {
            Yii::$app->session->setFlash('warning', Yii::t('cronjob.global', 'Update failed'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cronjob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cronjob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cronjob::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
