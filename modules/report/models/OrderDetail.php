<?php

namespace app\modules\report\models;
use app\modules\admin\models\Product;
use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id
 * @property int $order_id mã order
 * @property int $product_id mã sản phẩm
 * @property int $quantity số lượng sản phẩm
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity'], 'required'],
            [['order_id', 'product_id', 'quantity'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
