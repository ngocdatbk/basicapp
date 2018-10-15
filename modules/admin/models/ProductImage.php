<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property int $id
 * @property int $product_id id sản phẩm
 * @property string $image đường dẫn ảnh
 * @property string $description mô tả đi kèm
 * @property int $is_main có phải là ảnh chính
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'is_main'], 'integer'],
            [['image'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image' => 'Image',
            'description' => 'Description',
            'is_main' => 'Is Main',
        ];
    }

    public static function getImagesProduct ($product_id )
    {
        return ProductImage::findAll(['product_id' => $product_id]);
    }

    public static function getImagesMain ($product_id )
    {
        return ProductImage::findOne(['product_id' => $product_id, 'is_main' => 1]);
    }
}
