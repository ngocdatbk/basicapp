<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\Alert;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\permission\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user.user', 'View permission');
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="auth-item-index">
    <?= Alert::widget() ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'description',
                'label' => Yii::t('user.user', 'Permission'),
            ],

            [
                'label' => Yii::t('user.user', 'Allow'),
                'format' => 'raw',
                'value' => function ($model){
                    return Html::checkbox('permission['.$model['name'].']', (isset($model['allow']) && $model['allow']), ['value' => $model['name']]);
                },
            ],
        ],
    ]); ?>
</div>
