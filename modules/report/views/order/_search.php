<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\report\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_order_name') ?>

    <?= $form->field($model, 'user_order_phone') ?>

    <?= $form->field($model, 'user_order_email') ?>

    <?= $form->field($model, 'user_receive_name') ?>

    <?php // echo $form->field($model, 'user_receive_phone') ?>

    <?php // echo $form->field($model, 'user_receive_email') ?>

    <?php // echo $form->field($model, 'user_receive_address') ?>

    <?php // echo $form->field($model, 'order_time') ?>

    <?php // echo $form->field($model, 'user_note') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'admin_note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
