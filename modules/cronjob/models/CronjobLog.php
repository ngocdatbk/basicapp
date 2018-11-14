<?php

namespace app\modules\cronjob\models;

use Yii;

/**
 * This is the model class for table "cronjob_log".
 *
 * @property int $cronjob_id
 * @property int $execution_time
 * @property string $status
 */
class CronjobLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cronjob_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cronjob_id', 'execution_time', 'status'], 'required'],
            ['execution_time', 'integer'],
            [['status'], 'string', 'max' => 255],
            [['cronjob_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cronjob_id' => 'Cronjob ID',
            'execution_time' => 'Execution Time',
            'status' => 'Status',
        ];
    }
}
