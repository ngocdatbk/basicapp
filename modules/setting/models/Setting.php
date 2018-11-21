<?php

namespace app\modules\setting\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $key
 * @property string $value
 * @property int $modified
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['value'], 'string'],
            [['modified'], 'integer'],
            [['key'], 'string', 'max' => 50],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'key' => 'Key',
            'value' => 'Value',
            'modified' => 'Modified',
        ];
    }
}
