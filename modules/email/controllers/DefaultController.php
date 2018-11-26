<?php

namespace app\modules\email\controllers;

use app\components\Controller;

/**
 * Default controller for the `email-queue` module
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
