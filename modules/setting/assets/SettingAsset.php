<?php

namespace app\modules\setting\assets;

use yii\web\AssetBundle;

class SettingAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/setting/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/setting.js',
    ];

    public $css = [
        'css/setting.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
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