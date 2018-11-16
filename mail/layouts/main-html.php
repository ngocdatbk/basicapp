<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
        .order-result {
            overflow: auto;
            max-width: 500px;
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        .tr_le {background-color: #f2f2f2 !important;}

        .order-detail h4
        {
            font-weight: bold;
        }

        .order-detail .row-product {
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }

        .order-detail .row-product:last-child {
            border-bottom: 1px solid #ddd;
        }

        .product-image {
            width: 100%;
            padding-top: 66.667%;
            background-color: rgb(245, 245, 241);

            background-position: center center;
            background-repeat: no-repeat;
            background-size: contain;
            margin: 0 !important;
        }

        .row-product-detail {
            padding-bottom: 10px;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    xxx
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
