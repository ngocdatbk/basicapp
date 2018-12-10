<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\Alert;
use app\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user.title', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <p>
                    <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> '.Yii::t('user.field', 'Back To List'), ['index'], ['class' => 'btn btn-info']) ?>
                    <?= Html::a(Yii::t('user.field', 'Update'), ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a(Yii::t('user.field', 'Delete'), ['delete', 'id' => $model->user_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('user.field', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ])
                    ?>
                </p>
            </div>
            <div class="box-body">
                <?= Alert::widget(); ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'user_id',
                        'fullname',
                        'gender',
                        'email:email',
                        'phone_number',
                        [
                            'attribute' => 'is_active',
                            'value' => $model->is_active ? Yii::t('user.field', 'Active') : Yii::t('user.field', 'Inactive'),
                        ],
                        'roles'
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
