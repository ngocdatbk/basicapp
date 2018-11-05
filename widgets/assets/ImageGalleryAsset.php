<?php

namespace app\widgets\assets;

use yii\web\AssetBundle;

class ImageGalleryAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/widgets/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/image_gallery.js',
    ];

    public $css = [
        'css/image_gallery.css',
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