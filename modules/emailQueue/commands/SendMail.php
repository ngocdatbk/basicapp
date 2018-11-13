<?php

namespace app\modules\emailQueue\commands;

use Yii;
use app\commands\CronAbstractController;
use app\modules\emailQueue\components\EmailQueueHandler;
use app\modules\emailQueue\models\EmailQueue;

class SendMail extends CronAbstractController
{
    public function execute()
    {
        $model = new EmailQueue();
        $emailToSends = $model->getEmailToSend();

        foreach ($emailToSends as $emailToSend) {
            if (!EmailQueueHandler::sendMail($emailToSend)) {
                $emailToSend->setAttribute('status', -1); //for retry
                $emailToSend->save();
            } else {
                $emailToSend->delete();
            }
        }

        return true;
    }
}