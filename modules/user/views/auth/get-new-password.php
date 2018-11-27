<?php

use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('user.title', 'New password');
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?= Yii::$app->name ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="row">
            <div class="col-xs-12">
                <?= Alert::widget(); ?>

                <?php if (!$isError): ?>
                    <p>Xin chào <?= $user->fullname ?>!</p>
                    <p>Mật khẩu mới đã được gửi vào email của bạn. Vui lòng kiểm tra email để nhận mật khẩu mới</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->