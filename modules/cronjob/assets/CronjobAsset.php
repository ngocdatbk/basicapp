<?php

namespace app\modules\cronjob\assets;

use yii\web\AssetBundle;

class CronjobAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/cronjob/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/cron.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
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
