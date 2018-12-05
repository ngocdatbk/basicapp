<?php

namespace app\modules\email\models;

use Yii;

/**
 * This is the model class for table "email_queue".
 *
 * @property int $id
 * @property string $from email người gửi
 * @property string $to email người nhận
 * @property string $subject chủ đề mail
 * @property string $module_id module id để định vị đường dẫn email template
 * @property string $content_id content id để định vị đường dẫn email template
 * @property resource $extra_data dữ liệu đổ vào email template
 * @property int $created_date ngày tạo
 * @property int $status trạng thái của mail
 */
class EmailQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to', 'subject', 'content_id'], 'required'],
            [['to'], 'email'],
            [['extra_data'], 'string'],
            [['created_date', 'status'], 'integer'],
            [['from', 'to', 'subject', 'layout', 'module_id', 'content_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'subject' => 'Subject',
            'module_id' => 'Module ID',
            'content_id' => 'Content ID',
            'extra_data' => 'Extra Data',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }

    public static function queue($from, $to, $subject, $moduleId, $contentId, $extraData = null, $layout = null)
    {
        $emailQueue = new static();

        $emailQueue->setAttributes([
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'layout' => $layout,
            'module_id' => $moduleId,
            'content_id' => $contentId,
        ]);

        if ($extraData) {
            $emailQueue->setAttribute('extra_data', serialize($extraData));
        }

        if ($emailQueue->save()) {
            return true;
        }

        return false;
    }

    public function beforeSave($insert)
    {
        $this->created_date = time();

        return parent::beforeSave($insert);
    }

    public function getEmailToSend($limit = 5)
    {
        return static::find()
            ->where(['status' => 0])
            ->limit($limit)
            ->orderBy('created_date desc')
            ->all();
    }
}
