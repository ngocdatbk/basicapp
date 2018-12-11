<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\Alert;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\permission\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('permission.permission', 'Assign permission');
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('permission.permission', 'Assign permission');

?>
<div class="auth-item-index">
    <?= Alert::widget() ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'description',
                'label' => Yii::t('permission.permission', 'Permission'),
            ],

            [
                'label' => Yii::t('permission.permission', 'Allow'),
                'format' => 'raw',
                'value' => function ($model){
                    return Html::checkbox('permission['.$model['name'].']', (isset($model['allow']) && $model['allow']), ['value' => $model['name']]);
                },
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover']
    ]); ?>

    <?php ActiveForm::end(); ?>
</div>
