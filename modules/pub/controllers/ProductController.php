<?php

namespace app\modules\pub\controllers;

use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\models\ProductCategory;
use yii\data\Pagination;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $category_name = "All category";
        if (isset(Yii::$app->request->queryParams['category_id'])) {
            $category = ProductCategory::findOne(Yii::$app->request->queryParams['category_id']);
            $category_name = $category->name;
        }

        $query = Product::getAllProducts(isset(Yii::$app->request->queryParams['category_id'])?Yii::$app->request->queryParams['category_id']:'');

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 12,]);

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'products' => $products,
            'pagination' => $pagination,
            'category_name' => $category_name
        ]);
    }
    public function actionDetail()
    {
        if (isset(Yii::$app->request->queryParams['id'])) {
            $product = Product::findOne(Yii::$app->request->queryParams['id']);
            return $this->render('detail',['product' => $product]);
        } else {
            throw new BadRequestHttpException('Invalid request', 500);
        }
    }
}
