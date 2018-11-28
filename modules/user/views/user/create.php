<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->registerCss('.checkBoxClass label{margin-right: 0.3em; width: 45%}');
$this->title = Yii::t('user.title', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user.title', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <?= Alert::widget(); ?>
            <div class="box-header with-border">
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> '.Yii::t('user.field', 'Back To List'), ['index'], ['class' => 'btn btn-info']) ?>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>

                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('user.field' , 'Basic Information') ?></h3>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'gender')->radioList(['Male' => Yii::t('user.field' , 'Male'), 'Female' => Yii::t('user.field' , 'Female')]) ?>
                    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    <?= $form->field($model, 'is_admin')->checkbox(); ?>
                    <?= $form->field($model, 'is_active')->radioList([1 => Yii::t('user.field' , 'Active'), 0 => Yii::t('user.field' , 'Inactive')]) ?>

                    <?= Select2::widget([
                        'name' => 'kv-repo-template',
                        'value' => '14719648',
                        'initValueText' => ['india','chaina'],
                        'options' => [
                            'options' => ['placeholder' => 'Select user ...', 'multiple' => true],
                        ],
                        'pluginOptions' => [
                            'tags' => true,
                            'tokenSeparators' => [',', ' '],
                            'maximumInputLength' => 10,
                            'allowClear' => true,
                            'ajax' => [
                                'tags' => true,
                                'multiple' => true,
                                'url' => '/user/user/list-all-user',
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(company) { return company.text; }'),
                            'templateSelection' => new JsExpression('function (company) { return company.text; }'),
                        ],
                    ]) ?>
                </div>

                <div class="box-footer">
                    <?= Html::submitButton(Yii::t('user.field', 'Create'), ['class' => 'btn btn-success pull-right']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>