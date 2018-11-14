<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\Alert;
use app\modules\pub\assets\OrderAsset;

OrderAsset::register($this);
?>
<div class="container order-result">
    <div class="row">
        <div class="col-lg-12">
            <?= Alert::widget() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 order-info">
            <h2>Order info</h2>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'user_order_name',
                    'user_order_phone',
                    'user_order_email',
                    'user_receive_name',
                    'user_receive_phone',
                    'user_receive_email',
                    'user_receive_address',
                    'user_note',
                    [
                        'attribute' => 'total',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asCurrency($model->total);
                        },
                    ]
                ],
            ]) ?>
        </div>
        <div class="col-md-12 order-detail">
            <h2>Order detail</h2>
            <?php if ($model->orderDetail) {
            foreach($model->orderDetail as $order_detail){
                ?>
                <div class="row row-product">
                    <div class="col-sm-4 row-product-image">
                        <a href="<?= Url::to(['/pub/product/detail','id' => $order_detail->product_id]) ?>"><figure class="product-image" style="background-image: url('<?= Url::to('@web/'.$order_detail->product['image_main']) ?>')" ></figure></a>
                    </div>
                    <div class="col-sm-8  row-product-detail">
                        <h4><a href="<?= Url::to(['/pub/product/detail','id' => $order_detail->product_id]) ?>"><?= $order_detail->product['name'] ?></a></h4>
                        <?= $order_detail->quantity ?> x <?= Yii::$app->formatter->asCurrency($order_detail->product['price']) ?>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>
</div>
