<?php

namespace app\modules\email\controllers;

class EmailQueueController extends \app\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
