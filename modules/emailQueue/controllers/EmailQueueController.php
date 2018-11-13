<?php

namespace app\modules\emailQueue\controllers;

class EmailQueueController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
