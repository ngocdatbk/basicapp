<?php

namespace app\modules\emailQueue;
use Yii;
/**
 * email-queue module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\emailQueue\controllers';
    public $defaultRoute = 'email-queue';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, require (__DIR__ . '/config/web.php'));
        // custom initialization code goes here
        if (!isset(Yii::$app->i18n->translations['emailQueue.*'])) {
            Yii::$app->i18n->translations['emailQueue.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en_US',
                'basePath' => __DIR__.'/messages',
            ];
        }
    }
}
