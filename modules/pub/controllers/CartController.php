<?php

namespace app\modules\pub\controllers;
use Yii;
use yii\helpers\Json;
use app\modules\admin\models\Product;

class CartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $cart_cookie = array();
        $request_cookies = Yii::$app->request->cookies;

        if (isset($request_cookies['cart'])) {
            $cart_cookie = Json::decode($request_cookies['cart']->value);
        }
        return $this->render('index', ['cart_cookie' => $cart_cookie]);
    }

    public function actionAdd($product_id)
    {
        $cart_cookie = array();

        $request_cookies = Yii::$app->request->cookies;
        if (isset($request_cookies['cart'])) {
            $cart_cookie = Json::decode($request_cookies['cart']->value);
        }
        if (isset($cart_cookie[$product_id])) {
            $cart_cookie[$product_id]['quantity']++;
        }
        else{
            $product = Product::findOne($product_id);
            $cart_cookie[$product_id] = array('quantity' => 1, "detail" => $product->attributes);
        }

        $response_cookies = Yii::$app->response->cookies;
        $response_cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => Json::encode($cart_cookie),
            'expire' => time()+ 14*86400,
        ]));

        return $this->redirect("index");
    }

    public function actionUpdate()
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $product_id = $data['product_id'];
            $quantity = $data['quantity'];

            $cart_cookie = array();
            $request_cookies = Yii::$app->request->cookies;
            if (isset($request_cookies['cart'])) {
                $cart_cookie = Json::decode($request_cookies['cart']->value);
            }
            else {
                return Json::encode(array("result"=>"error"));
            }

            if (isset($cart_cookie[$product_id])) {
                $cart_cookie[$product_id]['quantity'] = (int)$quantity;
            }
            else {
                return Json::encode(array("result"=>"error"));
            }

            $cart_total = 0;
            foreach($cart_cookie as $car)
            {
                $cart_total += $car['quantity'];
            }

            $response_cookies = Yii::$app->response->cookies;
            $response_cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => Json::encode($cart_cookie),
                'expire' => time()+ 14*86400,
            ]));
            return Json::encode(array("result"=>"success",'cart_total' => $cart_total));
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $product_id = $data['product_id'];

            $cart_cookie = array();
            $request_cookies = Yii::$app->request->cookies;
            if (isset($request_cookies['cart'])) {
                $cart_cookie = Json::decode($request_cookies['cart']->value);
            }
            else {
                return Json::encode(array("result"=>"error"));
            }

            if (isset($cart_cookie[$product_id])) {
                unset($cart_cookie[$product_id]);
            }
            else {
                return Json::encode(array("result"=>"error"));
            }

            $cart_total = 0;
            foreach($cart_cookie as $car)
            {
                $cart_total += $car['quantity'];
            }

            $response_cookies = Yii::$app->response->cookies;
            $response_cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => Json::encode($cart_cookie),
                'expire' => time()+ 14*86400,
            ]));
            return Json::encode(array("result"=>"success",'cart_total' => $cart_total));
        }
    }

}
