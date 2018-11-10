<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\modules\report\assets\OrderAsset;

OrderAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\report\models\Order */

$this->title = 'Order '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_order_name',
            'user_order_phone',
            'user_order_email',
            'user_receive_name',
            'user_receive_phone',
            'user_receive_email',
            'user_receive_email',
            'user_receive_address',
            'user_note',
            [
                'attribute' => 'total',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asCurrency($model->total);
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Yii::$app->controller->module->params['order_status'][$model->status];
                },
            ],
            'admin_note',
        ],
    ]) ?>

</div>
<div class="order-detail">
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
