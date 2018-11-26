<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\widgets\Alert;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\form\LoginForm */

$this->title = Yii::t('user.title', 'Login');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?= Yii::$app->name ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= Yii::t('user.title', 'Login to start your session') ?></p>

        <?= Alert::widget(); ?>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form->field($model, 'email', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form->field($model, 'password', $fieldOptions2)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => Url::toRoute('/site/captcha'), 'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>']) ?>

        <div class="row">
            <div class="col-xs-7">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-5">
                <?= Html::submitButton(Yii::t('user.title', 'Login'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
            <p>- HOẶC -</p>
            <a href="<?= Url::to('/user/auth/login-google?authclient=google') ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> <?= Yii::t('user.title', 'Sign in using Google+') ?></a>
        </div>
        <!-- /.social-auth-links -->

        <?= Html::a(Yii::t('user.title', 'Forgot password?'), ['forgot-password']) ?><br>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
