<?php

namespace app\modules\dashboard\controllers;

class DashboardController extends \app\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
