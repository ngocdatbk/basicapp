<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\permission\models\AuthItem */

$this->title = 'Create role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
