<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\modules\admin\assets\ProductAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */

ProductAsset::register($this);
?>

<div class="product-form">
    <?php $form = ActiveForm::begin([
        'id' => 'product',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => $datas,
        'options' => ['placeholder' => Yii::t('admin.product_category', 'Select a category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <label class="control-label" for="image"><?= Yii::t('admin.product', 'Images') ?></label>
    <?= Html::input('file', 'images[]', null, ['class' => 'form-control', 'id' => 'images', 'multiple' => true, 'accept' => 'image/*']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= Html::img(isset($image_main)?Url::to('@web/'.$image_main->image):'', ['main_id' => isset($image_main)?'old_'.$image_main->id:'', 'id' => 'main_image', 'class' => "img-thumbnail image_product"]); ?>
        </div>
        <div class="col-sm-6" >
            <table class="table"  id="image_list">
                <tbody>
                    <?php if(!empty($images)): ?>
                        <?php foreach ($images as $key => $image): ?>
                            <tr>
                                <td class="bound_image" style="width: 25%">
                                    <?= Html::img(Url::to('@web/'.$image->image), ['id' => "old_".$image->id, 'class' => "img-thumbnail image_product"]); ?>
                                    <a class="remove_image" row_id="old_<?= $image->id ?>" old_new="old" type="button" >
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>

                                </td>
                                <td>
                                    <?= Html::textarea('image_old['.$image->id.'][description]', $image->description, ['placeholder' => "Enter text here...", 'rows' => '4', "style" => ["width" => "100%"]]); ?>
                                    <?= Html::hiddenInput('image_old['.$image->id.'][is_main]', $image->is_main, ['id' => 'main_old_'.$image->id]); ?>
                                    <?= Html::hiddenInput('image_old['.$image->id.'][status]', '', ['id' => 'status_old_'.$image->id]); ?>
                                    <?= Html::hiddenInput('image_old['.$image->id.'][id]', $image->id, ['id' => $image->id]); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app.global', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
