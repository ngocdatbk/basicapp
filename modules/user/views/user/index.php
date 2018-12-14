<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

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
            'gender',
            'email:email',
            'phone_number',
            [
                'attribute' => 'roles',
                'format' => 'raw',
                'value' => function ($model){
                    if ($model->assignments) {
                        $assignments = ArrayHelper::getColumn($model->assignments, function ($element) {
                            return Html::a($element['item_name'], ['/permission/role/assign-permission', 'id' => $element['item_name']], ['target' => '_blank']);
                        });
                        return implode(', ', $assignments);
                    } else
                        return '';
                }
            ],
            [
                'attribute' => 'is_active',
                'value' => function ($model){
                    if ($model->is_active)
                        return Yii::t("app.global",'Active');
                    else
                        return Yii::t("app.global",'Inactive');
                }
            ],
            [
                'attribute' => 'is_admin',
                'value' => function ($model){
                    if ($model->is_admin)
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {view_permission} {delete}',
                'buttons' => [
                    'view_permission' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['view-permission', 'id' => $key], [
                            'title' => Yii::t('user.user', 'View permission'),
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
