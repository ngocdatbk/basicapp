<?php

namespace app\helpers;

/**
 * Extend of \yii\helpers\ArrayHelper
 *
 * @author LuuCD <luuchuduc@admicro.vn>
 */

use Yii;

class MailHelper
{
    public static $viewPath = '@app/modules/{module}/views/email_template/';

    public static function sendSystemEmail($to, $subject, $moduleId, $action, $extraData)
    {
        $emailTemplate = static::getSystemEmailTemplate($moduleId, $action);

        try {
            Yii::$app->mailer->compose($emailTemplate, $extraData)
                ->setFrom(Yii::$app->params['outbound_mail_address'])
                ->setTo($to)
                ->setSubject('[' . Yii::$app->params['outbound_mail_from_name'] . '] ' . $subject)
                ->send();
        } catch (\yii\base\Exception $e) {
            Yii::$app->errorLog->logException($e);

            return false;
        }

        return true;
    }

    protected static function getSystemEmailTemplate($moduleId, $action)
    {
        return strtr(static::$viewPath, ['{module}' => $moduleId]) . strtolower('system_email' . '_' . $action);
    }
}
