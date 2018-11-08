<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use app\modules\pub\assets\CartAsset;

CartAsset::register($this);
?>
<div class="container shopping-cart">
    <div class="row">
        <div class="col-sm-8 cart-detail">
            <h2>Shopping Cart</h2>
            <div class="container-fluid">
                <?php
                $total_quantity = 0;
                $total_amount = 0;
                foreach($cart_cookie as $product_id => $product){
                    $total_quantity += $product['quantity'];
                    $total_amount += $product['detail']['price'] * $product['quantity'];
                ?>
                    <div class="row row-product">
                        <div class="col-sm-3 row-product-image">
                            <a href="<?= Url::to(['/pub/product-detail/index','id' => $product['detail']['id']]) ?>"><figure class="product-image" style="background-image: url('<?= Url::to('@web/'.$product['detail']['image_main']) ?>')" ></figure></a>
                        </div>
                        <div class="col-sm-6  row-product-detail">
                            <h4><a href="<?= Url::to(['/pub/product-detail/index','id' => $product['detail']['id']]) ?>"><?= $product['detail']['name'] ?></a></h4>
                            <input class="product-quantity" id="quantity-<?= $product['detail']['id'] ?>" product-id="<?= $product['detail']['id'] ?>" type="number" value="<?= $product['quantity'] ?>"> x <?= Yii::$app->formatter->asCurrency($product['detail']['price']) ?>
                        </div>
                        <div class="col-sm-3  row-product-control">
                            <button class="btn-product-control btn-product-delete" product-id="<?= $product['detail']['id'] ?>">Delete</button>
                            <button class="btn-product-control btn-product-update" id="update-<?= $product['detail']['id'] ?>" product-id="<?= $product['detail']['id'] ?>">Save</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-sm-4 checkout">
            <div class="total">
                <div class="total-left"><b>Cart Subtotal</b> (<?= $total_quantity ?> items)</div>
                <div class="total-right"><?= Yii::$app->formatter->asCurrency($total_amount) ?></div>
            </div>
            <div class="ship">Shipping and tax will be calculated on checkout</div>
            <button class="btn-checkout">Checkout</button>
        </div>
    </div>
</div>
