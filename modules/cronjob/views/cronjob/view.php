<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\cronjob\models\Cronjob */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cronjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cronjob-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('cronjob.global', 'Run manual'), ['run-manual', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('cronjob.global', 'Clear log'), ['delete-log', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('cronjob.global', 'Are you sure you want to delete this item?'),
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cronjob_id',
            'name',
            'class',
            'module_id',
            'run_rules',
            'last_run:dateTime',
            'next_run:dateTime',
            'is_active:boolean',
            'logging_f:boolean',
        ],
    ]) ?>

    <h2>Log running</h2>
    <div class="box box-primary">
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $logDataProvider,
                'columns' => [
                    'execution_time:dateTime',
                    'status',
                ],
                'options' => ['class' => 'grid-view table-responsive'],
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            ]);
            ?>
        </div>
    </div>
</div>