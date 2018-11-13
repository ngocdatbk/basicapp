<?php

namespace app\commands;

abstract class CronAbstractController extends \yii\console\Controller
{
    abstract public function execute();
}
