<?php
/* @var $this yii\web\View */
use app\widgets\ImageGallery;
use app\modules\pub\assets\ProductDetailAsset;

ProductDetailAsset::register($this);

?>

<div class="container">
    <div class="row">
        <div class="col-7 col-sm-7">
            <?= ImageGallery::widget([
                'images' => $product->productImage,
                'options' => [
                    'itemWidth' => 10
                ]
            ]) ?>
        </div>
        <div class="col-5 col-sm-5">
            <h2 class="product-name"><?= $product->name ?></h2>
            <span class="product-info"><?= $product->info ?></span>
            <span class="product-price"><b><?= Yii::$app->formatter->asCurrency($product->price) ?></b></span>
            <button class="btn btn-success btn-block" >Buy it now</button>

            <div class="social-share">
                <p>Chia sẻ thiết kế này!</p>
                <button class="btn btn-default"><i class="fa fa-facebook"></i> Facebook</button>
                <button class="btn btn-default"><i class="fa fa-twitter"></i> Twitter</button>
            </div>
        </div>
    </div>
</div>

