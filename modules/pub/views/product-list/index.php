<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use app\modules\pub\assets\ProductListAsset;
use yii\helpers\Html;
use yii\helpers\Url;

ProductListAsset::register($this);

$this->title = Yii::t("pub.product-list",$category_name);
$this->params['breadcrumbs'][] = Yii::t("pub.product-list",$category_name)."(".$pagination->totalCount." items)";
?>
<div class="row list-header">
    <div class="col-sm-6"><?= $category_name ?></div>
    <div class="col-sm-6">
        <span>Sort by:</span>
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Normal
                <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="active"><a href="#">Normal</a></li>
                <li><a href="#">Highest Price</a></li>
                <li><a href="#">Lowest Price</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row ">
    <div class="list-filters">

    </div>
    <div class="list-content">
        <div class="container-fluid">
            <div class="row">
                <?php foreach($products as $product_id => $product):?>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-image" style='background-image: url("<?= $product->image_main?Url::to('@web/'.$product->image_main):'' ?>");' > </div>
                            <div class="card-info">
                                <h5 class="card-name"><?= $product->name ?></h5>
                                <p class="card-info"><?= $product->info ?></p>
                                <h5 class="card-price"><?= $product->price ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="row">
                <div class="col-sm-12 pages">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>





