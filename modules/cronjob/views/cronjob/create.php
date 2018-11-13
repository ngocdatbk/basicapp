<?php

use yii\helpers\Html;
use app\modules\cronjob\assets\CronjobAsset;

CronjobAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\cronjob\models\Cronjob */

$this->title = 'Create Cronjob';
$this->params['breadcrumbs'][] = ['label' => 'Cronjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cronjob-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
