<?php

namespace app\modules\cronjob\controllers;

use app\components\Controller;

/**
 * Default controller for the `cronjob` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
