<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\admin\assets\LayoutAsset;
use yii\helpers\Url;

LayoutAsset::register($this);
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

<div class="wrap">
    <header class="main-header">
        <div class="header-logo">
            <a class="show-menu">
                <?= Yii::t("app.global","Admin") ?>
            </a>
        </div>
        <div class="header-menu">
            <?php
            NavBar::begin([
                'options' => [
                    'id' => 'navigations'
                ],
                'innerContainerOptions' => [
                    'class' => 'container-fluid'
                ]
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    Yii::$app->user->isGuest ? (
                    ['label' => 'Login', 'url' => ['/site/login']]
                    ) : (
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                    )
                ],
            ]);
            NavBar::end();
            ?>
        </div>

    </header>

    <div class="content">
        <aside class="content_menu">
            <section>
                <ul class="nav nav-list">
                    <li><label class="tree-toggler nav-header"><span class="glyphicon glyphicon-plus" style="float: right"></span> Productxxxxxxxxxxxxx</label>
                        <ul class="nav nav-list tree lv1">
                            <li><a href="<?= Url::to('/admin/product-category') ?>"> Product Category</a></li>
                            <li><a href="<?= Url::to('/admin/product') ?>"> Product</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li><label class="tree-toggler nav-header"><span class="glyphicon glyphicon-plus" style="float: right"></span>Report</label>
                        <ul class="nav nav-list tree lv1">
                            <li><a href="<?= Url::to('/report/report1') ?>"> Report1</a></li>
                            <li><a href="<?= Url::to('/report/report2') ?>"> Report2</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </aside>

        <div class="container-fluid content_body">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <p class="pull-left">&copy; ngocdatbk <?= date('Y') ?></p>

            <p class="pull-right"></p>
        </div>
    </footer>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
