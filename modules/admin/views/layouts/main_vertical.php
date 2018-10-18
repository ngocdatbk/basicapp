<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
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
        <?= Html::img(Url::to('@web/images/menu.ico'), ['class' => "show-menu"]); ?>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::t("app.global","Admin"),
            'brandUrl' => \yii\helpers\Url::to("/admin"),
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
                'id' => 'navigations'
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid'
            ]
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav '],
            'items' => [
                [
                    'label' => 'Product',
                    'url' => ['/admin/product'],
                    'items' => [
                        ['label' => 'Product Category', 'url' => ['/admin/product-category']],
                        ['label' => 'Product', 'url' => ['/admin/product']],
                    ]
                ],
                [
                    'label' => 'Report',
                    'url' => ['/report/report1'],
                    'items' => [
                        ['label' => 'Report1', 'url' => ['/report/report1']],
                        ['label' => 'Report2', 'url' => ['/report/report2']],
                    ]
                ],
            ],
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
    </header>


    <aside class="menu_left">
        <section>
            <ul class="nav nav-list">
                <li><label class="tree-toggler nav-header"><span class="glyphicon glyphicon-plus" style="float: right"></span> Header 1</label>
                    <ul class="nav nav-list tree">
                        <li><a href="#"> Link</a></li>
                        <li><a href="#"> Link</a></li>
                        <li><label class="tree-toggler nav-header"><span class="glyphicon glyphicon-plus" style="float: right"></span>Header 1.1</label>
                            <ul class="nav nav-list tree">
                                <li><a href="#"> Link</a></li>
                                <li><a href="#"> Link</a></li>
                                <li><label class="tree-toggler nav-header"><span class="glyphicon glyphicon-plus" style="float: right"></span>Header 1.1.1</label>
                                    <ul class="nav nav-list tree">
                                        <li><a href="#"> Link</a></li>
                                        <li><a href="#"> Link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><label class="tree-toggler nav-header"><span class="glyphicon glyphicon-plus" style="float: right"></span>Header 2</label>
                    <ul class="nav nav-list tree">
                        <li><a href="#"> Link</a></li>
                        <li><a href="#"> Link</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>

    <div class="container-fluid content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; ngocdatbk <?= date('Y') ?></p>

            <p class="pull-right"></p>
        </div>
    </footer>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
