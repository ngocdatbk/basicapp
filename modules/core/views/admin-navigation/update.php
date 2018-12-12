<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\core\models\AdminNavigation */

$this->title = Yii::t('core.admin_menu', 'Update {modelClass}: ', [
        'modelClass' => 'Admin Menu',
    ]) . $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core.admin_menu', 'Admin Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->navigation_id]];
$this->params['breadcrumbs'][] = Yii::t('core.admin_menu', 'Update');
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header width-border">
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('core.admin_menu', 'Back to list'), ['index'],['class' => 'btn btn-info']) ?>
			</div>
			<div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
					'parents' => $parents,
					'permission' => $permission
                ]) ?>
			</div>
		</div>
	</div>
</div>
