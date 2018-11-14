<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\cronjob\models\Cronjob;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Cronjob\models\search\CronjobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cronjobs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Cronjob-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cronjob', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'options' => ['style' => 'width:30px;'],
                'name' => 'cronjob_id',
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => $model->is_active ? '' : 'text-muted']);
                },
            ],
            'module_id',
            [
                'attribute' => 'next_run',
                'value' => function($model) {
                    return $model->is_active ? \app\helpers\AppLocale::dateTime($model->next_run, 'H:i:s d/m/Y') : '--';
                }
            ],
            [
                'attribute' => 'is_active',
                'value' => function($model) {
                    return Html::a($model->is_active ? 'Disable' : 'Active', ['change-active-status', 'id' => $model->id], [
                            'class' => $model->is_active ? 'btn btn-danger btn-xs' : 'btn btn-success btn-xs',
                            'title' => $model->is_active ? 'Disable cron job' : 'Active cron job',
                            'data' => $model->is_active ? [
                                'confirm' => Yii::t('cronjob.global', 'Are you sure you want to disable this item?'),
                                'method' => 'post',
                            ] : null,
                        ]
                    );
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                    $searchModel, 'is_active', [1 => 'Active', 0 => 'Not active'], ['class' => 'form-control', 'prompt' => '']
                ),
                'options' => ['style' => 'width:150px;'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'logging_f',
                'value' => function($model) {
                    return Html::a(
                        $model->logging_f ? 'Disable' : 'Active', ['change-logging-status', 'id' => $model->id], [
                            'class' => $model->logging_f ? 'btn btn-danger btn-xs' : 'btn btn-success btn-xs',
                            'data' => [
                                'confirm' => Yii::t('cronjob.global', ($model->logging_f ? 'Disable' : 'Enable') . ' logging?'),
                                'method' => 'post',
                            ],
                        ]
                    );
                },
                'format' => 'raw',
                'filter' => false,
                'options' => ['style' => 'width:50px;'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'label' => Yii::t('cronjob.global', 'Run manual'),
                'value' => function ($model) {
                    return $model->is_active ? Html::a(Yii::t('cronjob.global', 'Run'), ['run-manual', 'id' => $model->id]) : '';
                },
                'format' => 'raw',
                'options' => ['style' => 'width:92px;'],
                'contentOptions' => ['class' => 'text-center'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => ['class' => 'grid-view table-responsive'],
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
    ]); ?>
</div>
