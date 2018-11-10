<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\report\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">
    <?php $form = ActiveForm::begin(); ?>

    <label for="user_order">User order</label>
    <div class="row">
        <div class="col-sm-4"><?= $form->field($model, 'user_order_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel( 'user_order_name' )])->label(false) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'user_order_phone')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel( 'user_order_phone' )])->label(false) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'user_order_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel( 'user_order_email' )])->label(false) ?></div>
    </div>

    <label for="user_receive">User receive</label>
    <div class="row">
        <div class="col-sm-4"><?= $form->field($model, 'user_receive_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel( 'user_receive_name' )])->label(false) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'user_receive_phone')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel( 'user_receive_phone' )])->label(false) ?></div>
        <div class="col-sm-4"><?= $form->field($model, 'user_receive_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel( 'user_receive_email' )])->label(false) ?></div>
    </div>

    <?= $form->field($model, 'user_receive_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_note')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($orderStatus, [
        'onchange'=>'formLead.loadStatusByState(this.value)'
    ]) ?>

    <?= $form->field($model, 'admin_note')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?= $this->render('_order_details', ['model' => $model]) ?>
