<?php

namespace app\modules\core\assets;

use yii\web\AssetBundle;

class AdminNavigationAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/core/assets/dist';
    /**
     * @inheritdoc
     */
    public $js = [
        'js/admin_navigation.js',
    ];

    public $css = [
        'css/navigation.css'
    ];
    /**
     * @inheritdoc
     */
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
