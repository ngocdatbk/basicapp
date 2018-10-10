<?php

namespace app\helpers;

use Yii;

class GoogleHelper
{

    public static function getGoogleClient()
    {
        $client = new \Google_Client();
        $client->setClientId(Yii::$app->params['google']['client_id']);
        $client->setClientSecret(Yii::$app->params['google']['client_secret']);
        return $client;
    }
}