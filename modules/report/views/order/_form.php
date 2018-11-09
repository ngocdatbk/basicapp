<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\report\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_order_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_order_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_order_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_receive_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_receive_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_receive_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_receive_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_time')->textInput() ?>

    <?= $form->field($model, 'user_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'admin_note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
