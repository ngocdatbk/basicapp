<?php

use app\helpers\ArrayHelper;
use app\modules\core\assets\AdminNavigationAsset;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\core\models\AdminNavigation */
/* @var $form yii\widgets\ActiveForm */

AdminNavigationAsset::register($this);
?>

<div class="admin-navigation-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4"><?= $form->field($model, 'navigation_id')->textInput() ?></div>
                <div class="col-md-4">
                    <?= $form->field($model, 'menu_group')->dropDownList(ArrayHelper::getValue(Yii::$app->getModule('core')->params, 'group_menu'), ['onchange'=>"$('#parent_id').val(null).trigger('change');$('#display_before').val(null).trigger('change');"]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                        'options' => [
                            'placeholder' => Yii::t('core.admin_menu', 'Select parent menu') . ' ...',
                            'id' => 'parent_id'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'url' => '/core/admin-navigation/list-menu-parent' . (!$model->isNewRecord ? '?id='.$model->navigation_id : ''),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term, group:$(\'#adminnavigation-menu_group\').val()}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(parent) { return parent.text; }'),
                            'templateSelection' => new JsExpression('function (parent) { return parent.text; }'),
                            'tags' => false,
                        ],
                        'pluginEvents' => [
//                            "select2:select" => "function() { $('#display_before').val(null).trigger('change'); }",
                            "change" => "function() { $('#display_before').val(null).trigger('change'); }",
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-8"><?= $form->field($model, 'label_type')->dropDownList(ArrayHelper::getValue(Yii::$app->getModule('core')->params, 'label_type')) ?></div>
            </div>
            <div class="row">
                <div class="col-md-4"><?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-8"><?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'permission_type')->dropDownList(ArrayHelper::getValue(Yii::$app->getModule('core')->params, 'permission_type'), ['prompt' => 'Vui lòng chọn loại quyền', 'onChange' => 'changeType()']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'permission')->widget(Select2::classname(), [
                        'data' => $permission,
                        'options' => ['placeholder' => Yii::t('core.admin_menu', 'Select permission')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Permission Id'); ?>
                </div>
                <div class="col-md-4"><?= $form->field($model, 'permission')->textInput(['class' => 'form-control callback', 'id' => 'callback_permission', 'disabled' => 'disabled'])->label('Callback'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'display_before')->widget(Select2::classname(), [
                        'options' => [
                            'placeholder' => Yii::t('core.admin_menu', 'Select menu') . ' ...',
                            'id' => 'display_before'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'url' => '/core/admin-navigation/list-menu-child',
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term, parent_id:$(\'#parent_id\').val()}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(parent) { return parent.text; }'),
                            'templateSelection' => new JsExpression('function (parent) { return parent.text; }'),
                            'tags' => false,
                        ]
                    ]); ?>
                </div>
                <div class="col-md-4"><?= $form->field($model, 'debug_only')->checkbox(['value' => 1]) ?></div>
                <div class="col-md-4"><?= $form->field($model, 'display_f')->checkbox(['value' => 1]) ?></div>
            </div>
        </div>

		<div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('core.admin_menu', 'Create') : Yii::t('core.admin_menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>
</div>
