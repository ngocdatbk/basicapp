<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\permission\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
    <?= Alert::widget() ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create permission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description:ntext',
            'rule_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
