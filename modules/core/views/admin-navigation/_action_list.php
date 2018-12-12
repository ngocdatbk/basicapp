<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php if ($item['display_f']) : ?>
    <?= Html::a('<i class="fa fa-eye-slash"></i>', ['/core/admin-navigation/toggle-display', 'id' => $item['id']], ['title' => 'Bấm để ẩn']) ?>
<?php else: ?>
    <?= Html::a('<i class="fa fa-eye"></i>', ['/core/admin-navigation/toggle-display', 'id' => $item['id']], ['title' => 'Bấm để hiện']) ?>
<?php endif ?>

<?=
Html::a('<i class="fa fa-pencil"></i>', Url::to(['update', 'id' => $item['id']]), [
    'title' => 'Cập nhật',
]);
?>

<?=
Html::a('<i class="fa fa-lg fa-trash"></i>', ['/core/admin-navigation/delete', 'id' => $item['id']], [
    'data' => [
        'confirm' => 'Bạn có chắc là sẽ xóa mục này không?',
    ],
    'data-method' => 'post',
    'aria-label' => 'Xóa',
    'title' => 'Xóa',
]);
?>
