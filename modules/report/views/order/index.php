<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\report\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => Yii::t('report.order', 'Order code'),
            ],
            'user_order_name',
            'user_order_phone',
            'user_order_email:email',
            [
                'attribute' => 'order_time',
                'label' => Yii::t('report.order', 'Order time'),
                'format' => ['datetime', 'short'],
                'contentOptions' => [
                    'align' => 'right',
                ],
                'filter' => '<div class="input-group drp-container">' . DateRangePicker::widget([
                    'name' => 'OrderSearch[order_time]',
                    'useWithAddon' => true,
                    'convertFormat' => true,
                    'startAttribute' => 'OrderSearch[order_time][from_date]',
                    'endAttribute' => 'OrderSearch[order_time][to_date]',
                    'startInputOptions' => ['value' => isset(Yii::$app->request->get('OrderSearch')['order_time']['from_date']) ? Yii::$app->request->get('OrderSearch')['order_time']['from_date'] : '1-1-1970'],
                    'endInputOptions' => ['value' => isset(Yii::$app->request->get('OrderSearch')['order_time']['to_date']) ? Yii::$app->request->get('OrderSearch')['order_time']['to_date'] : date('d-m-Y')],
                    'pluginOptions' => [
                        'locale' => ['format' => 'd-m-Y'],
                        'opens'=>'left',
                        'ranges' => [
                            "Today" => ["moment().startOf('day')", "moment()"],
                            "Yesterday" => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
                            "Last 7 Days" => ["moment().startOf('day').subtract(6, 'days')", "moment()"],
                            "Last 30 Days" => ["moment().startOf('day').subtract(29, 'days')", "moment()"],
                            "This Month" => ["moment().startOf('month')", "moment().endOf('month')"],
                            "Last Month" => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
                        ],
                    ],
                ]). '</div>'
            ],
            [
                'attribute' => 'status',
                'label' => Yii::t('report.order', 'Status'),
                'value' => function ($model) {
                    return Yii::$app->controller->module->params['order_status'][$model->status];
                },
                'filter' => Yii::$app->controller->module->params['order_status']
            ],
            'admin_note',
            [
                'attribute' => 'total',
                'format' => ['decimal', 0],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
