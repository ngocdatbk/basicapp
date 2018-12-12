<?php

namespace app\modules\core;
use Yii;
/**
 * core module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\core\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::configure($this, require(__DIR__ . '/config/web.php'));
        // custom initialization code goes here
        if (!isset(Yii::$app->i18n->translations['core.*'])) {
            Yii::$app->i18n->translations['core.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en_US',
                'basePath' => __DIR__.'/messages',
            ];
        }
    }
}
