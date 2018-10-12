<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t("admin.product",'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t("app.global",'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t("app.global",'Delete'), ['delete', 'id' => $model->id], [
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
            'code',
            'name',
            'info:ntext',
            [
                'attribute' => 'price',
                'format' => ['decimal', 0],
            ],
            'category_id',
            [
                'attribute' => 'deleted_f',
                'value' => function ($model){
                    if($model->deleted_f)
                        return \Yii::t("app.global",'Deleted');
                    else
                        return '--';
                }
            ],
        ],
    ]) ?>

</div>
