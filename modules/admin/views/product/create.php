<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = Yii::t("admin.product",'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t("admin.product",'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'datas' => $categorys,
    ]) ?>

</div>
