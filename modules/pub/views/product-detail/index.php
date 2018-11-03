<?php
/* @var $this yii\web\View */
use yii\bootstrap\Carousel;
?>
<?= Carousel::widget([
    'items' => [
        // the item contains only the image
        '<img src="http://2.bp.blogspot.com/-5Qh1mWqMOQg/UjLEYPeJ4kI/AAAAAAAAGHA/ZAgbd4EHhGI/s1600/hinh-nen-thien-nhien-10.jpg"/>',
        // equivalent to the above
        ['content' => '<img src="http://baobinhphuoc.com.vn/Content/UploadFiles/EditorFiles/images/2017/Quy4/2559384317310646469067746543664106583080452n-151394302916822122017023843.jpg"/>'],
        // the item contains both the image and the caption
        [
            'content' => '<img src="https://www.ttcgroup.vn/media/10334/dalat3.jpg"/>',
            'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
        ],
    ]
]) ?>
