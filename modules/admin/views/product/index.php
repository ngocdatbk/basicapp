<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin.product', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('admin.product', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            'name',
            [
                'attribute' => 'info',
                'value' => function($model){
                    return \yii\helpers\StringHelper::truncate($model->info,20,'...');
                }
            ],
            [
                'attribute' => 'price',
                'format' => ['decimal', 0],
            ],
            [
                'attribute' => 'deleted_f',
                'value' => function ($model){
                    if($model->deleted_f)
                        return \Yii::t("app.global",'Deleted');
                    else
                        return '--';
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model){
                    if ($model->category)
                    {
                        return $model->category->name;
                    }
                    return "--";
                }
            ],
            //'image_main',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
