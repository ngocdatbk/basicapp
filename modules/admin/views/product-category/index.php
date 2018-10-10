<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t("admin.product_category",'Product Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t("admin.product_category",'Create Product Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            'description:ntext',
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view',
                    'update',
                    'delete' => function ($url, $model) {
                        if($model->deleted_f)
                            return Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['revert', 'id' => $model->id], [
                                'title' => Yii::t('app.global', 'Revert'),
                                'data' => [
                                    'confirm' => Yii::t('app.global', 'Are you sure you want to revert this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                        else
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app.global', 'Delete'),
                                'data' => [
                                    'confirm' => Yii::t('app.global', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                    }

                ],
            ],
        ],
    ]); ?>
</div>
