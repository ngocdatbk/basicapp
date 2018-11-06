<?php

use app\helpers\HtmlHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\assets\ImageGalleryAsset;

ImageGalleryAsset::register($this);
?>
<div class="image_container">

    <div class="feature">
        <figure class="featured-item image-holder r-3-2 transition" data-toggle="modal" data-target="#previewModal"></figure>
        <button class="move-btn left"><i style="font-size:22px" class="fa fa-angle-left"></i></button>
        <button class="move-btn right"><i style="font-size:22px" class="fa fa-angle-right"></i></button>
    </div>

    <div class="gallery-wrapper">
        <div class="gallery">
            <?php
            $i = 0;
            foreach($images as $image):?>
                <div class="item-wrapper">
                    <figure class="gallery-item image-holder r-3-2 <?= $image->is_main?'active':'' ?> transition" style="background-image: url('<?= Url::to('@web/'.$image->image) ?>')" index="<?= $i++ ?>"></figure>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div id="previewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <figure class="preview-image image-holder r-3-2 transition" ></figure>
            </div>
        </div>

    </div>
</div>