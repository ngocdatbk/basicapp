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
        $response_cookies->remove('cart');
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

            /*van de - k gui cookie ve dan den lan request sau cookie gui len khong duoc cap nhat*/
        }
    }

    public function actionDelete()
    {

    }

}
