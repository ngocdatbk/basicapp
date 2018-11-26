<?php

namespace app\modules\user;
use Yii;
/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';
    public $layoutPath = '@app\views\layouts';
    public $layout = '/admin_vertical';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::configure($this, require(__DIR__ . '/config/web.php'));
        // custom initialization code goes here
        if (!isset(Yii::$app->i18n->translations['user.*'])) {
            Yii::$app->i18n->translations['user.*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en_US',
                'basePath' => __DIR__.'/messages',
            ];
        }
    }
}
