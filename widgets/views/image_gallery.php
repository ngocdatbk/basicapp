<?php

use app\helpers\HtmlHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\assets\ImageGalleryAsset;

ImageGalleryAsset::register($this);
$this->registerJs(
    "var itemWidth = ".$options['itemWidth']."; // percent: as set in css"
);
?>
<div class="image_container">

    <div class="feature">
        <figure class="featured-item image-holder r-3-2 transition"></figure>
    </div>

    <div class="gallery-wrapper">
        <div class="gallery">
            <?php foreach($images as $image): ?>
                <div class="item-wrapper" style="width: <?= $options['itemWidth'] ?>%">
                    <figure class="gallery-item image-holder r-3-2 <?= $image->is_main?'active':'' ?> transition" style="background-image: url('<?= Url::to('@web/'.$image->image) ?>')"></figure>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="controls">
        <button class="move-btn left">&larr;</button>
        <button class="move-btn right">&rarr;</button>
    </div>

</div>