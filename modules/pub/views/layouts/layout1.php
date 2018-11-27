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
use yii\helpers\Json;

LayoutPubAsset::register($this);

$categorys = ProductCategory::getAllCategorys('all');

$request_cookies = Yii::$app->request->cookies;
$cart = 0;
if (isset($request_cookies['cart'])) {
    $cart_cookie = Json::decode($request_cookies['cart']->value);
    foreach($cart_cookie as $product)
    {
        $cart += $product['quantity'];
    }
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
    <div class="container-fluid fluid-newpad">
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
        <div class="header-customer" >
            <?php  if(Yii::$app->user->isGuest){ ?>
                <?= Html::a('Login','/user/auth/login') ?>
            <?php } else {?>
                <a class="dropdown-toggle dropdown_web" data-toggle="dropdown" href="#"><?= Yii::$app->user->identity->username ?> <span class="caret"></span></a>
                <a class="dropdown-toggle dropdown_mobile" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span></span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header">Product</li>
                    <li><a href="<?= Url::to('/admin/product-category') ?>"> Product Category</a></li>
                    <li><a href="<?= Url::to('/admin/product') ?>"> Product</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Report</li>
                    <li><a href="<?= Url::to('/report/order') ?>"> Order list</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">System tools</li>
                    <li><a href="<?= Url::to('/cronjob') ?>"> Cron tasks</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Manager User</li>
                    <li><a href="<?= Url::to('/user/user') ?>"> User list</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Setting</li>
                    <li><a href="<?= Url::to('/setting') ?>"> Setting</a></li>
                    <li class="divider"></li>
                    <li>
                        <?php
                        echo Html::beginForm(['/user/auth/logout'], 'post');
                        echo Html::submitButton(
                            'Logout',
                            ['class' => 'btn-logout']
                        );
                        echo Html::endForm();
                        ?>
                    </li>
                </ul>
            <?php }?>
            &nbsp;
            <a class="cart_container" href="<?= Url::to('/pub/cart/index') ?>">
                <i class="fa fa-shopping-cart cart_container">
                    <span class="cart_num" ><?= $cart ?></span>
                </i>
                <span>Cart</span>
            </a>
        </div>
    </div>
</header>

<div class="menu-hor">
    <div class="container-fluid fluid-newpad">
        <nav class="hor-container">
            <?php foreach($categorys as $categoryid => $category): ?>
                <?= Html::a($category->name, Url::to(['/pub/product/index', 'category_id' => $categoryid])) ?>
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
                    <?= Html::a($category->name, Url::to(['/pub/product/index', 'category_id' => $categoryid])) ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid fluid-newpad">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid fluid-newpad">
        <div class="pull-left">Saotruc</div>
        <div class="pull-right">&copy; ngocdatbk <?= date('Y') ?></div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
