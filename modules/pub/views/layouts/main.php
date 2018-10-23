<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\pub\assets\LayoutAsset;
use app\modules\admin\models\ProductCategory;
use yii\helpers\Url;

LayoutAsset::register($this);

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

<div class="header container-fluid">
    <div class="header-first row">
        <div class="col-sm-12">
            <div class="header-first-left">
                <a class="site-logo">
                    Saotruc
                </a>
            </div>
            <div class="header-first-right">
                <a class="site-logo">
                    Saotruc
                </a>
            </div>
        </div>
    </div>
    <div class="header-second row">
        <div class="col-sm-12">
            <?php
            NavBar::begin([
                'innerContainerOptions' => [
                    'class' => 'container-fluid'
                ]
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav '],
                'items' => $item
            ]);
            NavBar::end();
            ?>
        </div>
    </div>
</div>


<div class="wrap">

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<div class="footer container-fluid">
    <p class="pull-left">&copy; ngocdatbk <?= date('Y') ?></p>

    <p class="pull-right"></p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
