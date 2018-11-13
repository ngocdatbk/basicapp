<?php

namespace app\commands;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use app\modules\cronjob\models\CronJob as CronModel;
use app\modules\cronjob\models\CronjobLog as CronLogModel;
use app\modules\cronjob\helpers\CronHelper;

class CronController extends Controller
{

    public function actionIndex()
    {
        $tasks = CronModel::find()
        ->where(['is_active' => 1])
        ->andWhere(['<=', 'next_run', time()])
        ->orderBy(['next_run' => 'asc'])
        ->all();
        foreach ($tasks as $task) {
            $this->runTask($task);
        }
    }

    public function runTask($task)
    {
        $runRules = Json::decode($task->run_rules);
        $nextRun = CronHelper::calculateNextRunTime($runRules);
        $lastRun = time();

        if (CronModel::updateRunTime($task->cron_job_id, $nextRun, $lastRun)) {
            try {
                $this->logging($task, $lastRun, $this->execute($task));
            } catch (Exception $exc) {
                $this->logging($task, $lastRun, $exc->getMessage());
            }
        }
    }

    private function execute($task)
    {
        $cronClass = $task->class;
        if (!class_exists($cronClass)) {
            return 'Class does not exists.';
        }

        if (Yii::$app->hasModule($task->module_id)) {
            $module = Yii::$app->getModule($task->module_id);
        } else {
            return 'Module not found.';
        }

        $class = new $cronClass($task->cron_job_id, $module);
        if (!($class instanceof \app\commands\CronAbstractController)) {
            return 'Class is not an instanceof app\controllers\CronAbstractController class.';
        }

        $methodExecute = 'execute';

        if (!method_exists($class, $methodExecute)) {
            return 'Calling unknown method';
        }

        try {
            return $class->$methodExecute();
        } catch (\yii\base\UnknownMethodException $ex) {
            Yii::$app->errorLog->logException($ex);
            return $ex->getMessage();
        }
    }

    private function logging($task, $executionTime, $result)
    {
        if ($task->logging_f) {
            if ($result === true) {
                $status = 'Success.';
            } elseif ($result === false) {
                $status = 'Failed.';
            } else {
                $status = Json::encode($result);
            }

            $cronLogModel = new CronLogModel;
            $cronLogModel->cron_job_id = $task->cron_job_id;
            $cronLogModel->execution_time = $executionTime;
            $cronLogModel->status = $status;
            $cronLogModel->save();
        }
    }
}