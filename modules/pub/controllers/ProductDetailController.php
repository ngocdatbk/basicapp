<?php

namespace app\modules\pub\controllers;

use Yii;
use app\modules\admin\models\Product;

class ProductDetailController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(isset(Yii::$app->request->queryParams['id']))
        {
            $product = Product::findOne(Yii::$app->request->queryParams['id']);
            return $this->render('index',['product' => $product]);
        }else
        {
            throw new BadRequestHttpException('Invalid request', 500);
        }
    }

}
