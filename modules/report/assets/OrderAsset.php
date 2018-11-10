<?php

namespace app\modules\report\assets;

use yii\web\AssetBundle;

class OrderAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/report/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/order.js',
    ];
    public $css = [
        'css/order.css',
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