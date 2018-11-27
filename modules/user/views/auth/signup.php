<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\form\SignupForm */

$this->title = Yii::t('user.title', 'Signup');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];
$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
$fieldOptions4 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-log-in form-control-feedback'></span>"
];
?>

<div class="register-box">
    <div class="register-logo">
        <a href="#"><b><?= Yii::$app->name ?></b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg"><?= Yii::t('user.title', 'Register a new account') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

        <?= $form->field($model, 'email', $fieldOptions2)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form->field($model, 'fullname', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('fullname')]) ?>



        <?= $form->field($model, 'password', $fieldOptions3)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form->field($model, 'password_repeat', $fieldOptions4)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'captchaAction' => Url::toRoute('/site/captcha'),
            'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>'])
        ?>

        <?= Html::submitButton(Yii::t('user.title', 'Signup'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'signup-button']) ?>

        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up
                using
                Google+</a>
        </div>

<?= Html::a(Yii::t('user.title', 'I already have a account.'), ['login']) ?>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
