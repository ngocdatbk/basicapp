<?php

namespace app\modules\setting\controllers;

use Yii;
use app\modules\setting\models\SettingModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
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
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new SettingModel();
        $model->loadSettings();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach(Yii::$app->request->post('SettingModel') as $key => $value)
            {
                $model->saveSetting($key,$value);
            }
            $model->resetCache();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
