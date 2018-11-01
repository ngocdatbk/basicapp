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
        <?= Html::a("<span>Saotruc</span>", Url::home(), ['class' => "header-logo"]) ?>
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
        <a class="header-customer" href="https://www.w3schools.com/css/css_align.asp">
            <i class="fa fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
    </div>
</header>

<div class="menu-hor">
    <div class="container">
        <nav class="hor-container">
            <?php foreach($categorys as $categoryid => $category): ?>
                <?= Html::a($category->name, Url::to(['/pub/product-list/index', 'category_id' => $categoryid])) ?>
            <?php endforeach ?>
        </nav>
    </div>
</div>

<div class="menu-ver">
    <div class="ver-container" >
        <div class="ver-header">
            <div>
                <span>Saotruc</span>
                <button class="btn-link">&#10006;</button>
            </div>
            <div>
                <p>BROWSE CATEGORIES</p>
            </div>
        </div>

        <div class="ver-body">
            <div class="ver-content">
                <?php foreach($categorys as $categoryid => $category): ?>
                    <?= Html::a($category->name, Url::to(['/pub/product-list/index', 'category_id' => $categoryid])) ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
