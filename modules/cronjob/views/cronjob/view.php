<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\cronjob\models\Cronjob */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cronjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cronjob-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cron_job_id',
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

</div>
