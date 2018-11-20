<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\setting\models\Setting */

$this->title = 'Update Setting';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
