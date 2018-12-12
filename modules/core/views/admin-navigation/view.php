<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\core\models\AdminNavigation */

$this->title = $model->navigation_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.global', 'Admin Navigations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-navigation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app.global', 'Update'), ['update', 'id' => $model->navigation_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app.global', 'Delete'), ['delete', 'id' => $model->navigation_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app.global', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'navigation_id',
            'label',
            'icon',
            'url:url',
            'menu_group',
            'parent_id',
            'level',
            'label_type',
            'permission_type',
            'permission',
            'debug_only',
            'display_order',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
            'display_f'
        ],
    ]) ?>

</div>
