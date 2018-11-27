<?php

namespace app\modules\email\commands;

use Yii;
use app\commands\CronAbstractController;
use app\modules\email\models\EmailQueue;

class SendMail extends CronAbstractController
{
    public function execute()
    {
        $model = new EmailQueue();
        $emailToSends = $model->getEmailToSend();

//        $mailer = \Yii::createObject ( [
//            'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@app/mail',
//            'htmlLayout' => 'layouts/main-html',
//            'textLayout' => 'layouts/main-text',
//            'messageConfig' => [
//                'charset' => 'UTF-8',
//                'from' => ['noreply@site.com' => 'Saotruc.vn'],
//            ],
//            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'donaldclintonbjj@gmail.com',
//                'password' => 'dat@06101989',
//                'port' => '465',
//                'encryption' => 'ssl',
//            ]
//        ] );

        foreach ($emailToSends as $emailToSend) {
            $mailer = $emailToSend->from;
            if($emailToSend->layout)
                Yii::$app->$mailer->htmlLayout = "layouts/".$emailToSend->layout;

            if (!Yii::$app->$mailer->compose($emailToSend->module_id . "_" . $emailToSend->content_id,['data' => $emailToSend['extra_data']])
                ->setTo($emailToSend->to)
                ->setSubject($emailToSend->subject)
                ->send())
            {
                $emailToSend->setAttribute('status', -1); //for retry
                $emailToSend->save();
            } else {
                $emailToSend->delete();
            }
        }

        return true;
    }
}