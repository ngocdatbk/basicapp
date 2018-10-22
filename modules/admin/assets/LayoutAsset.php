<?php

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class LayoutAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/admin/assets/dist';

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