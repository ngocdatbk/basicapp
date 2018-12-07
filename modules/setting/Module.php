<?php

namespace app\modules\setting;
use Yii;
/**
 * setting module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\setting\controllers';
    public $defaultRoute = 'setting';

    public function init()
    {
        parent::init();

        // Register translations
        if (!isset(Yii::$app->i18n->translations['setting.*'])) {
            Yii::$app->i18n->translations['setting.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en_US',
            ];
        }
    }
}
