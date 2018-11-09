<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LayoutAdminAsset;

LayoutAdminAsset::register($this);
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
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t("app.global","Admin"),
        'brandUrl' => \yii\helpers\Url::to("/admin"),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
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



    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
