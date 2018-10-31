<?php

namespace app\modules\pub\assets;

use yii\web\AssetBundle;

class LayoutPubAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/pub/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/layout1.js',
    ];

    public $css = [
        'css/layout1.css',
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