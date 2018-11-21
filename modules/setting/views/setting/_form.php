<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\setting\assets\SettingAsset;
use yii\helpers\Url;

SettingAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\setting\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#system">System</a></li>
        <li><a data-toggle="tab" href="#email_marketting">Email marketing</a></li>
    </ul>

    <div class="tab-content">
        <a content_id="system" class="btn btn-primary btn-collapse">System</a>
        <div id="system" class="tab-pane fade in active">
            <?= $form->field($model, 'name', ['template' => "{label} span\n{input}\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="name" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->textInput(['maxlength' => true, 'disabled' =>true]) ?>

            <?= $form->field($model, 'status', ['template' => "{label} span\n{input}\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="status" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->dropdownList([
                    1 => 'item 1',
                    2 => 'item 2'
                ],
                ['prompt'=>'Select Category', 'disabled' =>true]
            ) ?>

            <?= $form->field($model, 'gender', ['template' => "{label} span\n{input}\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="gender" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->radioList([
                    1 => 'male',
                    2 => 'female'
                ],
                ['unselect' => null, 'itemOptions' => ['disabled' =>true]]
            ) ?>

            <?= $form->field($model, 'is_admin', ['template' => "{input} span\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="is_admin" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->checkbox([ 'disabled' =>true]) ?>
        </div>


        <a content_id="email_marketting" class="btn btn-primary btn-collapse">Email marketing</a>
        <div id="email_marketting" class="tab-pane fade in">
            <?= $form->field($model, 'email', ['template' => "{label} span\n{input}\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="email" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->textInput(['maxlength' => true, 'disabled' =>true]) ?>

            <?= $form->field($model, 'email_pass', ['template' => "{label} span\n{input}\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="email_pass" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->passwordInput(['name' => 'SettingModelPassword[email_pass]', 'value' => '', "placeholder" => $model->email_pass?"******":"", 'maxlength' => true, 'disabled' =>true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
