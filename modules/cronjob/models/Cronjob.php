<?php

namespace app\modules\cronjob\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "cronjob".
 *
 * @property int $id
 * @property string $cron_job_id
 * @property string $name Tên cron job
 * @property string $class lớp thực hiện cron job
 * @property string $module_id module chứa lớp thực hiện
 * @property resource $run_rules quy tắc lịch thực hiện
 * @property int $last_run thời gian chạy gần nhất
 * @property int $next_run thời gian của làn chạy tới
 * @property int $is_active trạng thái active
 * @property int $logging_f log hay không?
 */
class Cronjob extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cronjob';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cron_job_id', 'name', 'class', 'module_id', 'run_rules'], 'required'],
            [['run_rules'], 'string'],
            [['last_run', 'next_run', 'is_active', 'logging_f'], 'integer'],
            [['cron_job_id', 'module_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cron_job_id' => 'Cron Job ID',
            'name' => 'Name',
            'class' => 'Class',
            'module_id' => 'Module ID',
            'run_rules' => 'Run Rules',
            'last_run' => 'Last Run',
            'next_run' => 'Next Run',
            'is_active' => 'Is Active',
            'logging_f' => 'Logging F',
        ];
    }

    public function validateCronClass($attribute, $params)
    {
        if ($this->hasErrors($attribute)) {
            return false;
        }

        if (!$this->_classExists($this->$attribute)) {
            $this->addError($attribute, "Class '{$this->{$attribute}}' does not exist or has syntax error.");
            return false;
        }

        $method = empty($this->cron_method) ? 'execute' : $this->cron_method;
        $reflectionClass = new \ReflectionClass($this->$attribute);

        if (!$reflectionClass->hasMethod($method)) {
            $this->addError($attribute, 'invalid_method: ' . $method);
            return false;
        }

        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($reflectionMethod->isAbstract() || !$reflectionMethod->isPublic()) {
            $this->addError($attribute, 'Invalid method configuration.');
            return false;
        }

        if ($reflectionMethod->isStatic()) {
            $this->addError($attribute, 'Method is static.');
            return false;
        }

        return true;
    }

    public static function updateRunTime($cronJobId, $nextRun, $lastRun)
    {
        $cronJob = static::findOne(['cron_job_id' => $cronJobId]);
        $cronJob->next_run = $nextRun;
        $cronJob->last_run = $lastRun;

        return $cronJob->save(true, ['next_run', 'last_run']);
    }

    public function getRunRules()
    {
        if ($this->run_rules) {
            $runRules = Json::decode($this->run_rules);
        } else {
            $runRules = [
                'minutes' => [-1],
                'hours' => [-1],
                'day_type' => 'dow',
                'dow' => [-1],
                'dom' => [-1]
            ];
        }

        if (!isset($runRules['dow'])) {
            $runRules['dow'] = [-1];
        }

        if (!isset($runRules['dom'])) {
            $runRules['dom'] = [-1];
        }

        return $runRules;
    }

    protected function _classExists($className)
    {
        return class_exists($className) && in_array($className, get_declared_classes());
    }

    /**
     * Gets the minimum next run time stamp (ie, time next entry is due to run).
     * If no entries are runnable, returns 0x7FFFFFFF (basically never run an entry).
     *
     * @return integer
     */
    public function getMinimumNextRunTime()
    {
        $minNextRuntime = static::find()->where(['is_active' => static::CRONJOB_ACTIVE])->min('next_run');

        return $minNextRuntime ? $minNextRuntime : Yii::$app->time + 30 * 60;
    }

    /**
     * Updates the entry for the minimum next run time.
     * Cron calls are not needed until that point.
     *
     * @return integer Minimum next run time
     */
    public function updateMinimumNextRunTime()
    {
        $minimumRunTime = intval($this->getMinimumNextRunTime());

        if ($minimumRunTime) {
            \app\components\ConsoleApplication::defer('app\modules\deferred\components\deferreds\Cron', array(), 'cron', $minimumRunTime);
        }

        return $minimumRunTime;
    }
}
