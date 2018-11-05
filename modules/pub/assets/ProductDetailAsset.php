<?php

namespace app\modules\pub\assets;

use yii\web\AssetBundle;

class ProductDetailAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/pub/assets/dist';

    /**
     * @inheritdoc
     */

    public $css = [
        'css/product_detail.css',
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