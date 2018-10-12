<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\modules\admin\widgets\ImageWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'id' => 'product',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => $datas,
        'options' => ['placeholder' => Yii::t('admin.product_category', 'Select a category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= ImageWidget::widget(['images' => null]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app.global', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
