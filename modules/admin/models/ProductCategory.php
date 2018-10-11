<?php

namespace app\modules\admin\models;

use Yii;
use app\helpers\ArrayHelper;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property string $name Tên danh mục
 * @property string $description Mô tả về danh mục sản phẩm
 * @property int $deleted_f trạng thái của danh mục. nhận giá trị 0/1
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['deleted_f'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => \Yii::t("admin.product_category",'Name'),
            'description' => \Yii::t("admin.product_category",'Description'),
            'deleted_f' => \Yii::t("app.global",'Deleted'),
        ];
    }

    public static function getAllCategorys()
    {
        return ProductCategory::find()
            ->select(['name'])
            ->where('deleted_f != 1')
            ->indexBy('id')
            ->column();;
    }
}
