<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\cronjob\models\Cronjob */
/* @var $form yii\widgets\ActiveForm */

$runRules = $model->getRunRules();
$moduleIDs = array_keys(Yii::$app->modules);

$minutes = ['-1' => 'Any'];
for ($i = 0; $i < 60; $i++) {
    $minutes[$i] = $i;
}

$hours = ['-1' => 'Any'];
for ($i = 0; $i < 24; $i++) {
    $hours[$i] = $i;
}

$dayOfWeeks = [
    '-1' => 'Any',
    0 => 'Sunday',
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
];

$dayOfMonths = ['-1' => 'Any'];
for ($i = 0; $i < 32; $i++) {
    $dayOfMonths[$i] = $i;
}
?>

<div class="cronjob-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cronjob_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true, 'placeholder' => Yii::t('cronjob.global', 'With full namespace of execution class')]);?>

    <?= $form->field($model, 'module_id')->dropDownList(array_combine($moduleIDs, $moduleIDs), ['prompt' => Yii::t('cronjob.global', 'Select Module')]); ?>

    <div class="form-group">
        <label class="control-label"><?= Yii::t('cronjob.global', 'Minutes') ?></label>
        <?= HTML::listBox('minute[]', $runRules['minutes'], $minutes, ['multiple' => true, 'id' => 'minute', 'class' => 'form-control', 'size' => 8]) ?>
    </div>

    <div class="form-group">
        <label class="control-label"><?= Yii::t('cronjob.global', 'Hours') ?></label>
        <?= HTML::listBox('hour[]', $runRules['hours'], $hours, ['multiple' => true, 'id' => 'hour', 'class' => 'form-control', 'size' => 8]) ?>
    </div>

    <div class="radio">
        <label class="control-label">
            <?= Html::radio('day_type', ($runRules['day_type'] == 'dow') ? true : false, ['id' => 'cb_day_of_week', 'value' => 'dow']); ?>
            <?= Yii::t('cronjob.global', 'Days of week') ?>
        </label>

        <?= HTML::listBox('dayOfWeek[]', $runRules['dow'], $dayOfWeeks, ['multiple' => true, 'id' => 'dayOfWeek', 'class' => 'form-control', 'size' => 8]) ?>
    </div>

    <div class="radio">
        <label class="control-label">
            <?= Html::radio('day_type', ($runRules['day_type'] == 'dom') ? true : false, ['id' => 'cb_day_of_month', 'value' => 'dom']); ?>
            <?= Yii::t('cronjob.global', 'Days of month') ?>
        </label>

        <?= HTML::listBox('dayOfMonth[]', $runRules['dom'], $dayOfMonths, ['multiple' => true, 'id' => 'dayOfMonth', 'class' => 'form-control', 'size' => 8]) ?>
    </div>

    <div class="checkbox">
        <label class="control-label">
            <?= Html::checkbox('is_active', $model->is_active ? true : false); ?>
            <?= Yii::t('cronjob.global', 'Is Active') ?>
        </label>
    </div>

    <div class="checkbox">
        <label class="control-label">
            <?= Html::checkbox('logging_f', $model->logging_f ? true : false); ?>
            <?= Yii::t('cronjob.global', 'Logging') ?>
        </label>
    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app.global', 'Create') : Yii::t('app.global', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
