<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\core\models\AdminNavigation */

$this->title = Yii::t('core.admin_menu', 'Create Admin Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.global', 'Admin Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->display_f = 1;
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('core.admin_menu', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
			</div>
			<div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
					'permission' => $permission
                ]) ?>
			</div>
		</div>
	</div>
</div>
