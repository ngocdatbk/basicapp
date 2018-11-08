<?php

namespace app\modules\pub\controllers;

use Yii;
use yii\helpers\Json;
use app\modules\pub\models\Order;
use app\modules\pub\models\OrderDetail;

class OrderController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $order = new Order();
        $cart_cookie = array();
        $request_cookies = Yii::$app->request->cookies;

        if (isset($request_cookies['cart'])) {
            $cart_cookie = Json::decode($request_cookies['cart']->value);
        }

        if (Yii::$app->request->isPost && $order->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->getDb()->beginTransaction();

            $order->order_time = time();
            $order->status = 0;
            if(!$order->save())
            {
                $transaction->rollBack();
                return $this->redirect(['pub/cart/index']);
            }

            $total_amount = 0;
            foreach($cart_cookie as $detail)
            {
                $total_amount += $detail['detail']['price'] * $detail['quantity'];

                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $detail['detail']['product_id'];
                $orderDetail->quantity = $detail['quantity'];

                if(!$orderDetail->save())
                {
                    $transaction->rollBack();
                    return $this->redirect(['pub/cart/index']);
                }
            }

            $order->total = $total_amount;
            if(!$order->save())
            {
                $transaction->rollBack();
                return $this->redirect(['pub/cart/index']);
            }

            $transaction->commit();
        }

        return $this->render('create', [
            'model' => $order,
            'cart_cookie' => $cart_cookie
        ]);
    }

}
