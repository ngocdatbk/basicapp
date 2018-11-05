<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class ImageGallery extends Widget
{
    public $images;
    public $options = [
        'itemWidth' => 23
    ];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('image_gallery', [
                'images' => $this->images,
                'options' => $this->options,
        ]);
    }
}