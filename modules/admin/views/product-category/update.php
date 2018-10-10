<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ProductCategory */

$this->title = \Yii::t("admin.product_category",'Update Product Category').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t("admin.product_category",'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t("app.global",'Update');
?>
<div class="product-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
