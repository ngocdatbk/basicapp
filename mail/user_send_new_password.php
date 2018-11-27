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

<p>Xin chào <?php echo $data['fullname']; ?>!</p>
<p>Mật khẩu mới của bạn là: <strong><?php echo $data['password'] ?></strong></p>
<p>Vui lòng sử dụng mật khẩu này để <a href="<?php echo Url::to(['/user/auth/login'], true) ?>">đăng nhập</a> vào hệ thống và cập nhật mật khẩu trong Trang cá nhân</p>

