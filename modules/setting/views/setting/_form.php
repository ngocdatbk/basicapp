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
                ->textInput(['id' => "name", 'maxlength' => true, 'disabled' =>true]) ?>
        </div>


        <a content_id="email_marketting" class="btn btn-primary btn-collapse">Email marketing</a>
        <div id="email_marketting" class="tab-pane fade in">
            <?= $form->field($model, 'email', ['template' => "{label} span\n{input}\n{hint}\n{error}", 'parts' => ['span' => '<span class="input_edit" input_id="email" title="edit"><i class="fa fa-pencil"></i></span>']])
                ->textInput(['id' => "email", 'maxlength' => true, 'disabled' =>true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
