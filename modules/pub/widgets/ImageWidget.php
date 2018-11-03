<?php

namespace app\modules\admin\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;

class ImageWidget extends Widget
{

    public $images;
    public $fieldAdderOptions = [];
    public $defaultFieldAdderOptions = [
        'tag' => 'div',
        'id' => 'image-wp',
        'sourcElementClass' => 'input-group',
        'sourcElementTag' => 'div',
    ];

    public function init()
    {
        $this->fieldAdderOptions = ArrayHelper::merge($this->defaultFieldAdderOptions, $this->fieldAdderOptions);
        parent::init();
    }

    public function run()
    {
        return $this->render('wg_image', [
            'images' => $this->images,
            'fieldAdderOptions' => $this->fieldAdderOptions,
        ]);
    }

}
