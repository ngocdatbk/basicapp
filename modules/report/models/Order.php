<?php

namespace app\modules\report\models;
use app\modules\report\models\OrderDetail;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id mã order
 * @property string $user_order_name tên người đặt hàng
 * @property string $user_order_phone sđt người đặt hàng
 * @property string $user_order_e-mail email người đặt hàng
 * @property string $user_receive_name tên người nhận hàng
 * @property string $user_receive_phone sđt người nhận hàng
 * @property string $user_receive_e-mail email người nhận hàng
 * @property string $user_receive_address địa chỉ nhận hàng
 * @property int $order_time thời gian đặt hàng
 * @property string $user_note ghi chú đặt hàng
 * @property int $total tổng tiền hóa đơn
 * @property int $status trạng thái đơn hàng
 * @property string $admin_note ghi chú của admin
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_order_name', 'user_order_phone', 'user_receive_address'], 'required'],
            [['order_time', 'total', 'status'], 'integer'],
            [['user_order_name', 'user_order_email', 'user_receive_name', 'user_receive_email'], 'string', 'max' => 50],
            [['user_order_phone', 'user_receive_phone'], 'string', 'max' => 20],
            [['user_receive_address', 'user_note', 'admin_note'], 'string', 'max' => 255],
            [['user_order_email','user_receive_email'], 'email'],
            [['user_order_phone','user_receive_phone'], 'match', 'pattern' => '/^[0-9]{9,15}$/', 'message' => 'Number phone is not valid1'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_order_name' => 'User Order Name',
            'user_order_phone' => 'User Order Phone',
            'user_order_email' => 'User Order E Mail',
            'user_receive_name' => 'User Receive Name',
            'user_receive_phone' => 'User Receive Phone',
            'user_receive_email' => 'User Receive E Mail',
            'user_receive_address' => 'User Receive Address',
            'order_time' => 'Order Time',
            'user_note' => 'User Note',
            'total' => 'Total',
            'status' => 'Status',
            'admin_note' => 'Admin Note',
        ];
    }

    public function getOrderDetail()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id'])
            ->where(['deleted_f' => 0]);
    }
}
