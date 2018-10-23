<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use app\modules\pub\assets\ProductListAsset;
use yii\helpers\Html;
use yii\helpers\Url;

ProductListAsset::register($this);
?>
<div class="row">
    <?php foreach($products as $product_id => $product):?>
        <div class="col-sm-3" style="overflow: auto">
            <div class="card">
                <img class="card-img-top img-responsive" style="width: 100%; background: #000099;" src="<?= Url::to('@web/'.$product->image_main) ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="row">
    <div class="col-sm-12 pageee">
        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
    </div>
</div>



