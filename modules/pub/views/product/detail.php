<?php
/* @var $this yii\web\View */
use app\widgets\ImageGallery;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\pub\assets\ProductAsset;

ProductAsset::register($this);

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
            <form method="get" action="<?= Url::to("/pub/cart/add") ?>">
                <?= Html::hiddenInput("product_id",$product->id) ?>
                <button class="btn btn-success btn-block btn-buy" type="submit" >Buy it now</button>
            </form>
            <div class="social-share">
                <p>Chia sẻ sản phẩm này!</p>
                <button class="btn btn-default"><i class="fa fa-facebook"></i> Facebook</button>
                <button class="btn btn-default"><i class="fa fa-twitter"></i> Twitter</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Description</h3>
            <span class="product-info"><?= $product->info ?></span>
        </div>
    </div>
</div>

