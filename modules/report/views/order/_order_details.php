<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="order-detail">
    <h2>Order detail</h2>
    <?php
    if ($model->orderDetail) {
        $total_quantity = 0;
        $total_amount = 0;
        foreach($model->orderDetail as $order_detail){
            $total_quantity += $order_detail['quantity'];
            $total_amount += $order_detail->product['price'] * $order_detail['quantity'];
            ?>
            <div class="row row-product" id="row-product-<?= $order_detail['product_id'] ?>">
                <div class="col-sm-3 row-product-image">
                    <a href="<?= Url::to(['/pub/product/detail','id' => $order_detail['product_id']]) ?>"><figure class="product-image" style="background-image: url('<?= Url::to('@web/'.$order_detail->product['image_main']) ?>')" ></figure></a>
                </div>
                <div class="col-sm-5  row-product-detail">
                    <h4><a href="<?= Url::to(['/pub/product/detail','id' => $order_detail['product_id']]) ?>"><?= $order_detail->product['name'] ?></a></h4>
                    <input class="product-quantity" id="quantity-<?= $order_detail['product_id'] ?>" product-id="<?= $order_detail['product_id'] ?>" type="number" value="<?= $order_detail['quantity'] ?>"> x <?= Yii::$app->formatter->asCurrency($order_detail->product['price']) ?>
                </div>
                <div class="col-sm-4  row-product-control">
                    <?=
                    Html::button("Delete", [
                        'class' => 'btn-product-control btn-product-delete',
                        'id' => "delete-".$order_detail['product_id'],
                        'product-id' => $order_detail['product_id'],
                        'order-id' => $model->id,
                        'data' => [
                            'confirm' => Yii::t('report.order', 'Are you sure to delete this order?'),
                        ],
                    ])
                    ?>

                    <button class="btn-product-control btn-product-update" id="update-<?= $order_detail['product_id'] ?>" product-id="<?= $order_detail['product_id'] ?>" order-id="<?= $model->id ?>">Save</button>
                </div>
            </div>
    <?php }} ?>
</div>
