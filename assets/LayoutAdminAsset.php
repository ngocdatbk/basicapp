<?php

namespace app\assets;

use yii\web\AssetBundle;

class LayoutAdminAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/layout.js',
    ];

    public $css = [
        'css/layout.css',
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