<?php

namespace app\modules\setting\models;

use Yii;
use yii\base\Model;
use app\modules\setting\models\Setting;

class SettingModel extends Model
{
    public $email;
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 10],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
        ];
    }

    public function loadSettings()
    {
        $settings = Yii::$app->cache->getOrSet('setting', function () {
            return (new \yii\db\Query())
                ->select(['value'])
                ->from('setting')
                ->indexBy('key')
                ->column();
        });

        $this->attributes = $settings;
    }

    public function resetCache()
    {
        Yii::$app->cache->set('setting', (new \yii\db\Query())
            ->select(['value'])
            ->from('setting')
            ->indexBy('key')
            ->column());
    }

    public function saveSetting($key,$value)
    {
        $setting = Setting::findOne($key);
        if($setting === null)
        {
            $setting = new Setting();
            $setting->key = $key;
        }
        $setting->value = $value;
        $setting->modified = time();
        $setting->save();
    }
}
