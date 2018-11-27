<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('user.title', 'Forgot password');
?>

<!-- ################################## -->

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?= Yii::$app->name ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= Yii::t('user.title', 'Forgot password') ?></p>

        <?= Alert::widget(); ?>

        <?php $form = ActiveForm::begin(); ?>
        <div class="clearfix">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => '/site/captcha', 'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>']) ?>

            <div class="form-group">
                <?= Html::a(Yii::t('user.title', 'Cancel'), ['login'], ['class' => 'btn btn-default pull-left']) ?>
                <?= Html::submitButton(Yii::t('user.title', 'Get New Password'), ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- ################################## -->