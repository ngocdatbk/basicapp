<?php

namespace app\modules\dashboard;
use Yii;
/**
 * dashboard module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\dashboard\controllers';
    public $layoutPath = '@app\views\layouts';
    public $layout = '/admin_vertical';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        if (!isset(Yii::$app->i18n->translations['dashboard.*'])) {
            Yii::$app->i18n->translations['dashboard.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en_US',
                'basePath' => __DIR__.'/messages',
            ];
        }
    }
}
