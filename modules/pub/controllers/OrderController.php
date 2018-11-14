<?php

namespace app\modules\pub\controllers;

use Yii;
use yii\helpers\Json;
use app\modules\report\models\Order;
use app\modules\report\models\OrderDetail;

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
                Yii::$app->session->setFlash('error', 'System error');
                return $this->render('create', [
                    'model' => $order,
                    'cart_cookie' => $cart_cookie
                ]);
            }

            $total_amount = 0;
            foreach($cart_cookie as $detail)
            {
                $total_amount += $detail['detail']['price'] * $detail['quantity'];

                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $detail['detail']['id'];
                $orderDetail->quantity = $detail['quantity'];

                if(!$orderDetail->save())
                {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'System error');
                    return $this->render('create', [
                        'model' => $order,
                        'cart_cookie' => $cart_cookie
                    ]);
                }
            }

            $order->total = $total_amount;
            if(!$order->save())
            {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'System error');
                return $this->render('create', [
                    'model' => $order,
                    'cart_cookie' => $cart_cookie
                ]);
            }
            if($order->user_order_email){
                if(!\app\modules\emailQueue\models\EmailQueue::queue(Yii::$app->params['email_marketing'], $order->user_order_email, 'Order success', Yii::$app->controller->module->id, 'order_invoice', $order->getAttributes()+['detail' => $cart_cookie]))
                {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'System error');
                    return $this->render('create', [
                        'model' => $order,
                        'cart_cookie' => $cart_cookie
                    ]);
                }
            }

            $transaction->commit();

            $response_cookies = Yii::$app->response->cookies;
            $response_cookies->remove('cart');

            Yii::$app->session->setFlash('success', 'Create order success!');


            return $this->redirect(["result",'order_id' => $order->id]);
        }

        return $this->render('create', [
            'model' => $order,
            'cart_cookie' => $cart_cookie
        ]);
    }

    public function actionResult($order_id)
    {
        $order = Order::findOne($order_id);
        return $this->render('result', [
            'model' => $order
        ]);
    }
}
