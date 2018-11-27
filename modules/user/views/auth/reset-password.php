<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

//$this->title = Yii::t('user.title', 'Set new password');
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?= Yii::$app->name ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= Yii::t('user.global', 'Reset your password') ?></p>

        <?= Alert::widget(); ?>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_repeat')->passwordInput()->label('Xác nhận mật khẩu') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('user.title', 'Reset'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>        
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->