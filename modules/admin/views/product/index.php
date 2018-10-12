<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\Select2;

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
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model){
                    if($model->deleted_f)
                        return '<del>'.$model->name.'</del>';
                    else
                        return $model->name;
                }
            ],
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
                },
                'filter' => [
                    0 => Yii::t('app.global', 'Using'),
                    1 => Yii::t('app.global', 'Deleted'),
                ]
            ],
            [
                'attribute' => 'category.name',
                'value' => function ($model){
                    if ($model->category)
                    {
                        return $model->category->name;
                    }
                    return "--";
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => $categorys,
                    'options' => ['placeholder' => Yii::t('admin.product_category', 'Select a category')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            //'image_main',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {revert}',
                'buttons' => [
                    'revert' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['revert', 'id' => $key], [
                            'title' => Yii::t('app.global', 'Revert'),
                            'data' => [
                                'confirm' => Yii::t('app.global', 'Are you sure you want to revert this item?'),
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'visibleButtons' => [
                    'view',
                    'update',
                    'delete' => function ($model, $key, $index) {
                        return $model->deleted_f != 1;
                    },
                    'revert' => function ($model, $key, $index) {
                        return $model->deleted_f == 1;
                    }
                ],
            ],
        ],
    ]); ?>
</div>
