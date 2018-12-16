<?php

namespace app\widgets;

use yii;
use Yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\bootstrap\Alert as BootstrapAlert;

class ViewAs extends Widget
{

    public function run()
    {
        return $this->render('view_as', [
            'isViewAs' => $this->getIsViewAs(),
        ]);
    }

    protected function getIsViewAs()
    {
        $loggedUserId = Yii::$app->session->get('loggedUserId');
        $viewAsData = Yii::$app->dataRegistry->get('viewAsUser');

        if (isset($viewAsData[$loggedUserId]['loggedUserId']) && $viewAsData[$loggedUserId]['loggedUserId'] == $loggedUserId) {
            return true;
        }

        return false;
    }

}
