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
            [['code', 'name', 'info', 'image_main', 'category_id'], 'required'],
            [['info'], 'string'],
            [['price', 'category_id', 'deleted_f'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['image_main'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'info' => 'Info',
            'price' => 'Price',
            'image_main' => 'Image Main',
            'category_id' => 'Category ID',
            'deleted_f' => 'Deleted F',
        ];
    }
}
