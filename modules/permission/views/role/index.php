<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\permission\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
    <?= Alert::widget() ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {assign_permission} {delete}',
                'buttons' => [
                    'assign_permission' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['assign-permission', 'id' => $key], [
                            'title' => Yii::t('permission.permission', 'Assign permission'),
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
