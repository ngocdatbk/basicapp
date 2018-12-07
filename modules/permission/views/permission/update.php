<?php

use yii\helpers\Html;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\permission\models\AuthItem */

$this->title = 'Update permission: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-item-update">
    <?= Alert::widget() ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
