<?php

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class ProductAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/admin/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/product.js',
    ];

    public $css = [
        'css/product.css',
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