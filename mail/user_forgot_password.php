<?php
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: ngocd
 * Date: 11/14/18
 * Time: 9:35
 */
$data = unserialize($data);
?>


<!--<p>Xin chào --><?php //echo $data['fullname']; ?><!--!</p>-->
<!--<p>Chúng tôi đã nhận được yêu cầu lấy lại mật khẩu cho tài khoản của bạn. Nếu bạn yêu cầu, vui lòng click vào đường link dưới đây để nhận mật khẩu mới: </p>-->
<!--<p><a href="--><?php //echo Url::to(['/user/auth/get-new-password', 'confirm_key' => $data['confirm_key']], true) ?><!--">Nhận mật khẩu mới</a></p>-->
<!--<p>Nếu bạn không thực hiện yêu cầu này, bạn có thể bỏ qua thông báo này và mật khẩu của bạn sẽ được giữ nguyên.</p>-->

<p>Xin chào <?php echo $data['fullname']; ?>!</p>
<p>Chúng tôi đã nhận được yêu cầu reset mật khẩu cho tài khoản của bạn. Nếu bạn yêu cầu, vui lòng click vào đường link dưới đây để nhập mật khẩu mới: </p>
<p><a href="<?php echo Url::to(['/user/auth/reset-password', 'confirm_key' => $data['confirm_key']], true) ?>">Nhập mật khẩu mới</a></p>
<p>Nếu bạn không thực hiện yêu cầu này, bạn có thể bỏ qua thông báo này và mật khẩu của bạn sẽ được giữ nguyên.</p>

