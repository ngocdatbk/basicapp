<?php

namespace app\modules\pub;
use Yii;
/**
 * pub module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\pub\controllers';
    public $layoutPath = '@app\modules\pub\views\layouts';
    public $layout = 'layout1';
    public $defaultRoute = "dashboard/index";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        if (!isset(Yii::$app->i18n->translations['pub.*'])) {
            Yii::$app->i18n->translations['pub.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en_US',
                'basePath' => __DIR__.'/messages',
            ];
        }
        if (!isset(Yii::$app->i18n->translations['admin.*'])) {
            Yii::$app->i18n->translations['admin.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en_US',
                'basePath' => __DIR__.'/messages',
            ];
        }
    }
}
