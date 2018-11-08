<?php

namespace app\modules\pub\assets;

use yii\web\AssetBundle;

class CartAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/pub/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/cart.js',
    ];
    public $css = [
        'css/cart.css',
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