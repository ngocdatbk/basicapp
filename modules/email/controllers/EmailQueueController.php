<?php

namespace app\modules\email\controllers;

class EmailQueueController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
