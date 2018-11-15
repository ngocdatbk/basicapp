<?php
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: ngocd
 * Date: 11/14/18
 * Time: 9:35
 */
$order = unserialize($data);
?>


<div class="order-result">
    <div style="overflow-x:auto;" class="order-info">
        <h2>Order info</h2>
        <table>
            <tr class="tr_le">
                <td><b>User Order Name</b></td>
                <td><?= $order['user_order_name'] ?></td>
            </tr>
            <tr>
                <td><b>User Order Phone</b></td>
                <td><?= $order['user_order_phone'] ?></td>
            </tr>
            <tr class="tr_le">
                <td><b>User Order E Mail</b></td>
                <td><?= $order['user_order_email'] ?></td>
            </tr>
            <tr>
                <td><b>User Receive Name</b></td>
                <td><?= $order['user_receive_name'] ?></td>
            </tr>
            <tr class="tr_le">
                <td><b>User Receive Phone</b></td>
                <td><?= $order['user_receive_phone'] ?></td>
            </tr>
            <tr>
                <td><b>User Receive E Mail</b></td>
                <td><?= $order['user_receive_email'] ?></td>
            </tr>
            <tr class="tr_le">
                <td><b>User Receive Address</b></td>
                <td><?= $order['user_receive_address'] ?></td>
            </tr>
            <tr>
                <td><b>User Note</b></td>
                <td><?= $order['user_note'] ?></td>
            </tr>
            <tr class="tr_le">
                <td><b>Total</b></td>
                <td><?= Yii::$app->formatter->asCurrency($order['total']) ?></td>
            </tr>
        </table>
    </div>

    <div class="order-detail">
        <h2>Order detail</h2>
        <?php foreach($order['detail'] as $order_detail): ?>
            <div class="row row-product">
                <div class="row-product-image">
                    <a href="<?= Url::to(['/pub/product/detail','id' => $order_detail['detail']['id']],true) ?>"><figure class="product-image" style="background-image: url('<?= $message->embed(Url::to('/'.$order_detail['detail']['image_main'],true)); ?>')" ></figure></a>
                </div>
                <div class="row-product-detail">
                    <h4><a href="<?= Url::to(['/pub/product/detail','id' => $order_detail['detail']['id']],true) ?>"><?= $order_detail['detail']['name'] ?></a></h4>
                    <?= $order_detail['quantity'] ?> x <?= Yii::$app->formatter->asCurrency($order_detail['detail']['price']) ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

