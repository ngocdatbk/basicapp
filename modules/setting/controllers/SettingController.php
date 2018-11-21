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

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post('SettingModel'));
            $model->load(Yii::$app->request->post('SettingModelPassword'));
            if($model->validate())
            {
                if(Yii::$app->request->post('SettingModel'))
                    foreach(Yii::$app->request->post('SettingModel') as $key => $value)
                    {
                        Yii::$app->settings->set($key,$value);
                    }
                if(Yii::$app->request->post('SettingModelPassword'))
                foreach(Yii::$app->request->post('SettingModelPassword') as $key => $value)
                {
                    if($value)
                        Yii::$app->settings->set($key,utf8_encode(Yii::$app->security->encryptByKey($value, $key)));
                }
                Yii::$app->settings->resetCache();
            }
        }

        $model->attributes = Yii::$app->settings->getAll();
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
