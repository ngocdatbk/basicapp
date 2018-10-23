<?php

namespace app\modules\pub\controllers;

use Yii;
use app\modules\admin\models\Product;
use yii\data\Pagination;

class ProductListController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Product::getAllProducts(isset(Yii::$app->request->queryParams['category_id'])?Yii::$app->request->queryParams['category_id']:'');

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 10,]);

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', ['products' => $products, 'pagination' => $pagination]);
    }

}
