<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\models\ProductCategory;
use app\modules\admin\models\ProductImage;
use app\modules\admin\models\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\ProductImageUpload;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categorys = ProductCategory::getAllCategorys();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categorys' => $categorys,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = Yii::$app->getDb()->beginTransaction();

            $imageFiles = UploadedFile::getInstancesByName('images');
            foreach ($imageFiles as $file) {
                $imageUploads = new ProductImageUpload();
                $imageUploads->imageFile = $file;
                $path = '';
                if ($path = $imageUploads->upload()) {
                    $productImage = new ProductImage();
                    $productImage->product_id = $model->id;
                    $productImage->image = $path;

                    if(!$productImage->save())
                    {
                        $transaction->rollBack();
                        return $this->redirect(['index']);
                    }
                }
                else
                {
                    $transaction->rollBack();
                    return $this->redirect(['index']);
                }
            }

            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $categorys = ProductCategory::getAllCategorys();

        return $this->render('create', [
            'model' => $model,
            'categorys' => $categorys,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo "<pre>";
            var_dump(Yii::$app->request->post());
            echo "<pre>";
            exit();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $images = ProductImage::getImagesProduct($model->id);
        $categorys = ProductCategory::getAllCategorys();

        return $this->render('update', [
            'model' => $model,
            'categorys' => $categorys,
            'images' => $images
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model)
        {
            $model->deleted_f = 1;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->redirect(['index']);
    }

    public function actionRevert($id)
    {
        $model = $this->findModel($id);
        if($model)
        {
            $model->deleted_f = 0;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
