<?php

namespace app\modules\cronjob;
use Yii;
/**
 * cronjob module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\cronjob\controllers';
    public $defaultRoute = 'cronjob';

    public function init()
    {
        parent::init();

        // Register translations
        if (!isset(Yii::$app->i18n->translations['cronjob.*'])) {
            Yii::$app->i18n->translations['cronjob.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en_US',
            ];
        }
    }
}
