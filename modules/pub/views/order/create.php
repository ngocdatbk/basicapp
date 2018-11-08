<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use app\modules\pub\assets\OrderAsset;

OrderAsset::register($this);
?>
<div class="container order">
    <div class="row">
        <div class="col-lg-12">
            <?= Alert::widget() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 checkout">
            <h2>Checkout</h2>
            <?php $form = ActiveForm::begin([
                'id' => 'order'
            ]); ?>
            <fieldset>
                <legend>Personalia:</legend>
                <?= $form->field($model, 'user_order_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'user_order_phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'user_order_email')->textInput(['maxlength' => true]) ?>
            </fieldset>


            <?= $form->field($model, 'user_receive_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'user_receive_phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'user_receive_email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'user_receive_address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_note')->textarea(['maxlength' => true]) ?>


            <div class="form-group">
                <?= Html::submitButton(Yii::t('app.global', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-4 order-detail">
            <h4>
                Order Summary
                <a class="edit-cart" href="<?= Url::to(['/pub/cart/index']) ?>">Modify Order</a>
            </h4>

            <div class="container-fluid">
                <?php
                $total_quantity = 0;
                $total_amount = 0;
                foreach($cart_cookie as $product_id => $product){
                    $total_quantity += $product['quantity'];
                    $total_amount += $product['detail']['price'] * $product['quantity'];
                    ?>
                    <div class="row row-product" id="row-product-<?= $product['detail']['id'] ?>">
                        <div class="col-sm-4 row-product-image">
                            <a href="<?= Url::to(['/pub/product/detail','id' => $product['detail']['id']]) ?>"><figure class="product-image" style="background-image: url('<?= Url::to('@web/'.$product['detail']['image_main']) ?>')" ></figure></a>
                        </div>
                        <div class="col-sm-8  row-product-detail">
                            <h4><a href="<?= Url::to(['/pub/product/detail','id' => $product['detail']['id']]) ?>"><?= $product['detail']['name'] ?></a></h4>
                            <?= $product['quantity'] ?> x <?= Yii::$app->formatter->asCurrency($product['detail']['price']) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="total">Total : <?= Yii::$app->formatter->asCurrency($total_amount) ?></div>
        </div>
    </div>
</div>
