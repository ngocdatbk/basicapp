<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\setting\models\SettingSection */

$this->title = 'Create Section';
$this->params['breadcrumbs'][] = ['label' => 'Setting Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
