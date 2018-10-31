<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\pub\assets\LayoutPubAsset;
use app\modules\admin\models\ProductCategory;
use yii\helpers\Url;

LayoutPubAsset::register($this);

$categorys = ProductCategory::getAllCategorys('all');
$item = [];
foreach($categorys as $categoryid => $category)
{
    $item[] = ['label' => $category->name, 'url' => Url::to(['/pub/product-list/index', 'category_id' => $categoryid])];
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="header">
    <div class="container">
        <a class="header-logo" href="https://www.w3schools.com/css/css_align.asp">
            <span>Saotruc</span>
        </a>
        <div class="header-button">
            <button class="btn-link">
                <i class="fa fa-bars"></i>
                <span>Browse</span>
            </button>
        </div>
        <div class="header-search">
            <form method="get" action="">
                <div class="input-group search-content">
                    <input id="search-query" type="text" class="form-control" name="search-query" placeholder="Search for items">
                    <span class="input-group-addon">Search</span>
                </div>
            </form>
        </div>
    </div>
</header>

<div class="menu-hor">
    <div class="container">

    </div>
</div>

<div class="content">
    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="pull-left">Saotruc</div>
        <div class="pull-right">&copy; ngocdatbk <?= date('Y') ?></div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
