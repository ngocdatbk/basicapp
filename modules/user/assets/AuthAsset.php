<?php

namespace app\modules\user\assets;

use yii\web\AssetBundle;

class AuthAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/user/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/auth.js',
    ];

    public $css = [
        'css/auth.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\FontAwesomeAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->publishOptions['forceCopy'] = YII_ENV_DEV;
    }

}