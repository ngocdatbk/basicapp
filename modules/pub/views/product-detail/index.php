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
            ]) ?>
        </div>
        <div class="col-5 col-sm-5">
            <h2 class="product-name"><?= $product->name ?></h2>
            <span class="product-price"><b><?= Yii::$app->formatter->asCurrency($product->price) ?></b></span>
            <button class="btn btn-success btn-block btn-buy" >Buy it now</button>

            <div class="social-share">
                <p>Chia sẻ sản phẩm này!</p>
                <button class="btn btn-default"><i class="fa fa-facebook"></i> Facebook</button>
                <button class="btn btn-default"><i class="fa fa-twitter"></i> Twitter</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h2>Description</h2>
            <span class="product-info"><?= $product->info ?></span>
        </div>
    </div>
</div>

