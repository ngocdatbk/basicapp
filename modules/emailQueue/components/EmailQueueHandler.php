<?php

namespace app\modules\emailQueue\components;

use app\helpers\ArrayHelper;
use app\modules\emailQueue\models\EmailQueue;
use Yii;
use yii\base\ErrorException;
use yii\helpers\Inflector;

class EmailQueueHandler
{
    /**
     * Path to notify view template
     * @var type
     */
    public static $viewPath = '@app/modules/{module}/views/email_template/';


    public static function getEmailTemplate($module_id, $content_id)
    {
        $module = str_replace('\\', '/', $module_id);
        return strtr(self::$viewPath, ['{module}' => lcfirst(Inflector::id2camel($module))]) . strtolower('email_queue_' . $content_id );
    }

    /**
     *
     * @param EmailQueue $emailToSend email_queue active record
     * @return boolean
     */
    public static function sendMail($emailToSend)
    {
        $from = $emailToSend->from;
        $to = $emailToSend->to;
        $subject = $emailToSend->subject;

        //body
        try {
            $emailTemplate = self::getEmailTemplate($emailToSend->module_id, $emailToSend->content_id);

            $body = self::renderBody($emailTemplate, $emailToSend);

            return self::send($from, $to, $subject, $body);
        } catch (ErrorException $e) {
            Yii::$app->errorLog->logException($e);

            return false;
        }
    }

    protected static function send($from, $to, $subject, $body)
    {
        return Yii::$app->mailer->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }

    public static function renderBody($emailTemplate, $emailToSend)
    {

    }
}