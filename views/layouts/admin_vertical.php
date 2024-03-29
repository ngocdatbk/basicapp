<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LayoutAdminAsset;
use app\assets\AppAsset;
use yii\helpers\Url;

LayoutAdminAsset::register($this);
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

<div class="wrap dis-table">
    <div class="dis-row">
        <header class="main-header dis-cell">
            <div class="header-logo">
                <a class="show-menu">
                    <i class="fa fa-bars"></i> <?= Yii::t("app.global","Admin") ?>
                </a>
            </div>
            <div class="header-menu">
                <a class="item-header-menu" href="/">Go site</span></a>
                <div class="dropdown item-header-menu">
                    <a class="dropdown-toggle dropdown_web" data-toggle="dropdown" href="#"><?= Yii::$app->user->identity->username ?> <span class="caret"></span></a>
                    <a class="dropdown-toggle dropdown_mobile" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span></span></a>
                    <ul class="dropdown-menu">
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
                </div>
            </div>

        </header>
    </div>

    <div class="dis-row">
        <div class="dis-cell">
            <div class="dis-table">
                <div class="content dis-row">
                    <aside class="content_menu ">
                        <section>
                            <?= \app\modules\core\widgets\SidebarNavigationWidget::widget(); ?>
                        </section>
                    </aside>

                    <div class="container-fluid content_body dis-cell">
                        <?= app\widgets\ViewAs::widget() ?>
                        <?= Breadcrumbs::widget([
                            'homeLink' => [
                                'label' => 'Home',  // required
                                'url' => '/dashboard/dashboard',      // optional, will be processed by Url::to()
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                        <?= Alert::widget() ?>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer dis-row">
        <div class="container-fluid dis-cell">
            <p class="copyright">&copy; ngocdatbk <?= date('Y') ?></p>
        </div>
    </footer>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
