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
<style type="text/css">
    .order-result {
        overflow: auto;
        max-width: 500px;
        margin: 0 auto;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    .order-detail h4
    {
        font-weight: bold;
    }

    .order-detail .row-product {
        border-top: 1px solid #ddd;
        padding: 10px 0;
    }

    .order-detail .row-product:last-child {
        border-bottom: 1px solid #ddd;
    }

    .product-image {
        width: 100%;
        padding-top: 66.667%;
        background-color: rgb(245, 245, 241);

        background-position: center center;
        background-repeat: no-repeat;
        background-size: contain;
        margin: 0 !important;
    }

    .row-product-detail {
        padding-bottom: 10px;
    }
</style>

<div class="order-result">
    <div style="overflow-x:auto;" class="order-info">
        <h2>Order info</h2>
        <table>
            <tr>
                <td><b>User Order Name</b></td>
                <td><?= $order['user_order_name'] ?></td>
            </tr>
            <tr>
                <td><b>User Order Phone</b></td>
                <td><?= $order['user_order_phone'] ?></td>
            </tr>
            <tr>
                <td><b>User Order E Mail</b></td>
                <td><?= $order['user_order_email'] ?></td>
            </tr>
            <tr>
                <td><b>User Receive Name</b></td>
                <td><?= $order['user_receive_name'] ?></td>
            </tr>
            <tr>
                <td><b>User Receive Phone</b></td>
                <td><?= $order['user_receive_phone'] ?></td>
            </tr>
            <tr>
                <td><b>User Receive E Mail</b></td>
                <td><?= $order['user_receive_email'] ?></td>
            </tr>
            <tr>
                <td><b>User Receive Address</b></td>
                <td><?= $order['user_receive_address'] ?></td>
            </tr>
            <tr>
                <td><b>User Note</b></td>
                <td><?= $order['user_note'] ?></td>
            </tr>
            <tr>
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
                    <a href="<?= Url::to(['/pub/product/detail','id' => $order_detail['detail']['id']],true) ?>"><figure class="product-image" style="background-image: url('<?= Url::to('/'.$order_detail['detail']['image_main'],true) ?>')" ></figure></a>
                </div>
                <div class="row-product-detail">
                    <h4><a href="<?= Url::to(['/pub/product/detail','id' => $order_detail['detail']['id']],true) ?>"><?= $order_detail['detail']['name'] ?></a></h4>
                    <?= $order_detail['quantity'] ?> x <?= Yii::$app->formatter->asCurrency($order_detail['detail']['price']) ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

