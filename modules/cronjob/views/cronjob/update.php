<?php

use yii\helpers\Html;
use app\modules\cronjob\assets\CronjobAsset;

CronjobAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\cronjob\models\Cronjob */

$this->title = 'Update Cronjob: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cronjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cronjob-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
