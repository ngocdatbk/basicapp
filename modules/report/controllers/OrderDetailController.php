<?php

namespace app\modules\report\controllers;
use Yii;
use yii\helpers\Json;
use app\modules\report\models\OrderDetail;

class OrderDetailController extends \app\components\Controller
{
    public function actionUpdate()
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $order_id = $data['order_id'];
            $product_id = $data['product_id'];
            $quantity = $data['quantity'];

            $orderDetail = OrderDetail::find()->where(['order_id' => $order_id, 'product_id' => $product_id])->one();
            $orderDetail->quantity = $quantity;
            if($orderDetail->save())
                return Json::encode(array("result"=>"success"));
            else
                return Json::encode(array("result"=>"error"));
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $order_id = $data['order_id'];
            $product_id = $data['product_id'];

            $orderDetail = OrderDetail::find()->where(['order_id' => $order_id, 'product_id' => $product_id])->one();
            $orderDetail->deleted_f = 1;
            if($orderDetail->save())
                return Json::encode(array("result"=>"success"));
            else
                return Json::encode(array("result"=>"error"));
        }
    }
}
