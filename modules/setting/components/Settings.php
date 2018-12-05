<?php
namespace app\modules\setting\components;
use Yii;
use yii\base\Component;
use app\modules\setting\models\Setting as SettingDatabase;

class Settings extends Component
{
    public function init()
    {
        parent::init();
        $this->resetCache();
    }

    public function getAll()
    {
        return $settings = Yii::$app->cache->getOrSet('setting', function () {
            return (new \yii\db\Query())
                ->select(['value'])
                ->from('setting')
                ->indexBy('key')
                ->column();
        });
    }

    public function get($key, $default = null)
    {
        $settings = $this->getAll();
        return $this->has($key)?$settings[$key]:$default;
    }

    public function set($key, $value)
    {
        $setting = SettingDatabase::findOne($key);
        if ($setting === null) {
            $setting = new SettingDatabase();
            $setting->key = $key;
        }

        $setting->value = $value;
        $setting->modified = time();
        if(!$setting->save())
            return false;

        $this->resetCache();
        return true;
    }

    public function has($key): bool
    {
        $settings = $this->getAll();
        return !isset($settings[$key]);
    }

    public function resetCache()
    {
        Yii::$app->cache->set('setting', (new \yii\db\Query())
            ->select(['value'])
            ->from('setting')
            ->indexBy('key')
            ->column());
    }
}