<?php

namespace app\modules\user\components;

//use app\modules\user\models\UserCaution;
use Yii;
use app\helpers\AppLocale;

/**
 * Class User
 * @package app\modules\user\components
 *
 * @property boolean $isSuperAdmin This property is read-only
 */
class User extends \yii\web\User
{

    /**
     * @inheritDoc
     */
    public $identityClass = 'app\modules\user\models\User';
    private static $_preference = false;

    /**
     * @inheritDoc
     */
//    public $loginUrl = ['/user/auth/login'];

    public function init()
    {
        parent::init();
        AppLocale::setDefaultTimeZone(Yii::$app->timeZone); //set default timezone for user
    }

    public function getIsSuperAdmin()
    {
        if (isset(Yii::$app->params['superAdmin'])) {
            return in_array($this->id, Yii::$app->params['superAdmin']);
        }

        return $this->id == 1;
    }

    public function getIsAdmin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->isSuperAdmin || Yii::$app->user->identity->is_admin;
        }
    }

    public function getPreference($key = null)
    {
        $preference = null;

        if (self::$_preference !== false) {
            $preference = self::$_preference;
        } else {
            $preference = $this->_getUserPreference();
            self::$_preference = $preference;
        }

        if ($key && is_string($key)) {
            return \yii\helpers\ArrayHelper::getValue($preference, $key);
        }

        return $preference;
    }

    public function updatePreference($key, $value)
    {
        if (empty($key) || !is_string($key) || is_object($value)) {
            return false;
        }

        $preference = $this->_getUserPreference();
        $preference[$key] = $value;

        self::$_preference = $preference;

        $preference = \yii\helpers\Json::encode($preference);
        return file_put_contents($this->_getPreferenceFilePath(), $preference);
    }

    protected function _getUserPreference()
    {
        $pPath = $this->_getPreferenceFilePath();

        if ($pPath && file_exists($pPath)) {
            $preference = file_get_contents($pPath);
            $preference = \yii\helpers\Json::decode($preference);

            return $preference;
        }

        return null;
    }

    protected function _getPreferenceFilePath()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        return Yii::getAlias('@app') . '/' . Yii::$app->params['user_preference_path'] . Yii::$app->user->id;
    }

    /**
     * This method is called after the user is successfully logged in.
     * The default implementation will trigger the [[EVENT_AFTER_LOGIN]] event.
     * If you override this method, make sure you call the parent implementation
     * so that the event is triggered.
     * @param IdentityInterface $identity the user identity information
     * @param boolean $cookieBased whether the login is cookie-based
     * @param integer $duration number of seconds that the user can remain in logged-in status.
     * If 0, it means login till the user closes the browser or the session is manually destroyed.
     */
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
        $identity->last_login = time();
        $identity->save();

//        if (($userCaution = UserCaution::findOne(['user_id' => Yii::$app->user->id])) !== null) {
//            $userCaution->delete();
//        };
    }

}
