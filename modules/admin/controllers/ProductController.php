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

            if(Yii::$app->request->post('image_new') && $imageFiles = UploadedFile::getInstancesByName('images')){
                $new_images = Yii::$app->request->post('image_new');

                foreach ($imageFiles as $index => $file) {
                    $imageUpload = new ProductImageUpload();
                    $imageUpload->imageFile = $file;

                    if ($path = $imageUpload->upload()) {
                        $productImage = new ProductImage();
                        $productImage->product_id = $model->id;
                        $productImage->image = $path;
                        $productImage->description = $new_images[$index]['description'];
                        $productImage->is_main = $new_images[$index]['is_main'];

                        if(!$productImage->save())
                        {
                            $transaction->rollBack();
                            return $this->redirect(['index']);
                        }

                        if($productImage->is_main)
                        {
                            $model->image_main = $productImage['image'];
                            $model->save();
                        }
                    }
                    else
                    {
                        $transaction->rollBack();
                        return $this->redirect(['index']);
                    }
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
            $transaction = Yii::$app->getDb()->beginTransaction();

            //old image
            if($old_images = Yii::$app->request->post('image_old'))
            {
                foreach($old_images as $old_image)
                {
                    if (($productImage = ProductImage::findOne($old_image['id'])) !== null) {
                        if($old_image['status'] == 'delete')
                        {
                            $productImage->delete();
                            unlink(Yii::getAlias("@app")."/web/".$productImage->image);
                            if($old_image['is_main'] and $productImage['image'] == $model->image_main)
                            {
                                $model->image_main = '';
                                $model->save();
                            }
                        }
                        else
                        {
                            $productImage->description = $old_image['description'];
                            $productImage->is_main = $old_image['is_main'];
                            $productImage->save();

                            if($old_image['is_main'] and $productImage['image'] != $model->image_main)
                            {
                                $model->image_main = $productImage['image'];
                                $model->save();
                            }
                        }
                    }
                }
            }

            //new image
            if(Yii::$app->request->post('image_new') && $imageFiles = UploadedFile::getInstancesByName('images')){
                $new_images = Yii::$app->request->post('image_new');

                foreach ($imageFiles as $index => $file) {
                    $imageUpload = new ProductImageUpload();
                    $imageUpload->imageFile = $file;

                    if ($path = $imageUpload->upload()) {
                        $productImage = new ProductImage();
                        $productImage->product_id = $model->id;
                        $productImage->image = $path;
                        $productImage->description = $new_images[$index]['description'];
                        $productImage->is_main = $new_images[$index]['is_main'];

                        if(!$productImage->save())
                        {
                            $transaction->rollBack();
                            return $this->redirect(['index']);
                        }

                        if($productImage->is_main)
                        {
                            $model->image_main = $productImage['image'];
                            $model->save();
                        }
                    }
                    else
                    {
                        $transaction->rollBack();
                        return $this->redirect(['index']);
                    }
                }
            }

            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $images = ProductImage::getImagesProduct($model->id);
        $image_main = ProductImage::getImagesMain($model->id);

        $categorys = ProductCategory::getAllCategorys();

        return $this->render('update', [
            'model' => $model,
            'categorys' => $categorys,
            'images' => $images,
            'image_main' => $image_main
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