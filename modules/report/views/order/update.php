<?php

use yii\helpers\Html;
use app\modules\report\assets\OrderAsset;

OrderAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\report\models\Order */

$this->title = 'Update Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Order '.$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'orderStatus' => $orderStatus,
    ]) ?>

</div>
