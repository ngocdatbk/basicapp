<?php

namespace app\modules\emailQueue\commands;

use Yii;
use app\commands\CronAbstractController;
use app\modules\emailQueue\models\EmailQueue;

class SendMail extends CronAbstractController
{
    public function execute()
    {
        $model = new EmailQueue();
        $emailToSends = $model->getEmailToSend();

        foreach ($emailToSends as $emailToSend) {
            if (!Yii::$app->mailer->compose($emailToSend->module_id . "_" . $emailToSend->content_id,['data' => $emailToSend['extra_data']])
                ->setFrom($emailToSend->from)
                ->setTo($emailToSend->to)
                ->setSubject($emailToSend->subject)
                ->send()) {
                $emailToSend->setAttribute('status', -1); //for retry
                $emailToSend->save();
            } else {
//                $emailToSend->delete();
            }
        }

        return true;
    }
}