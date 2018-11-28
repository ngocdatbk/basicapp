<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fullname',
            'username',
            'gender',
            'email:email',
            'phone_number',
            [
                'attribute' => 'is_active',
                'value' => function ($model){
                    if($model->is_active)
                        return Yii::t("app.global",'Active');
                    else
                        return Yii::t("app.global",'Inactive');
                }
            ],
            [
                'attribute' => 'is_admin',
                'value' => function ($model){
                    if($model->is_active)
                        return Yii::t("app.global",'Admin');
                    else
                        return '';
                }
            ],
            [
                'attribute' => 'last_login',
                'label' => Yii::t('app.global', 'Last login'),
                'format' => ['datetime', 'short'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
