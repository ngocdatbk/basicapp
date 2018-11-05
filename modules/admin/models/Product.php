<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $code mã sản phẩm
 * @property string $name Tên sản phẩm
 * @property string $info thông tin chi tiết sản phẩm
 * @property int $price giá
 * @property string $image_main ảnh chính của sản phẩm
 * @property int $category_id danh mục sản phẩm
 * @property int $deleted_f trạng thái xóa, nhận giá trị 0/1
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'info', 'category_id'], 'required'],
            [['info'], 'string'],
            [['price', 'category_id', 'deleted_f'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['image_main'], 'string', 'max' => 100],
            ['code', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => Yii::t('app.global', 'Code'),
            'name' => Yii::t('app.global', 'Name'),
            'info' => Yii::t('app.global', 'Info'),
            'price' => Yii::t('app.global', 'Price'),
            'image_main' => 'Image Main',
            'category_id' => Yii::t("admin.product",'Category'),
            'deleted_f' => Yii::t("app.global",'Deleted'),
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    public function getProductImage()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    public static function getAllProducts($category_id = '')
    {
        $query = Product::find()
            ->where('deleted_f != 1')
            ->indexBy('id');
        if($category_id)
            $query->andFilterWhere(['category_id' => $category_id]);
        return $query;
    }
}
