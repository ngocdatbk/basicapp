<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\core\models\search\AdminNavigationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('core.admin_menu', 'Admin Menu');
$this->params['breadcrumbs'][] = $this->title;

\app\modules\core\assets\AdminNavigationAsset::register($this);
?>

<div class="row">
    <div class="col-xs-12">
        <?= \app\widgets\Alert::widget() ?>
        <div class="box box-primary">
            <div class="box-header">
                <div class="dropdown pull-left">
                    <?= Html::a(Yii::t('core.admin_menu', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('core.admin_menu', 'Clear'), ['clear-cache'], ['class' => 'btn btn-default']) ?>
                </div>

                <?php if (!empty($groupMenu = Yii::$app->getModule('core')->params['group_menu'])) : ?>
                    <div class="dropdown pull-right">
                        <?php $items[] = ['label' => Yii::t('core.admin_menu', 'All menu'), 'url' => Url::to(['index'])];
                        foreach ($groupMenu as $key => $item) : ?>
                            <?php $items[] = ['label' => Yii::t('core.admin_menu', $item), 'url' => Url::to(['index', 'group' => $key])]; ?>
                        <?php endforeach; ?>
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false">
                            <?php if (!empty(Yii::$app->request->queryParams['group'])) : ?>
                                <?= Yii::t('core.admin_menu', ArrayHelper::getValue($groupMenu, Yii::$app->request->queryParams['group'])) ?>
                            <?php else: ?>
                                <?= Yii::t('core.admin_menu', 'All menu') ?>
                            <?php endif ?>
                            <span class="caret"></span>
                        </button>
                        <?= Dropdown::widget([
                            'items' => $items
                        ]);
                        ?>
                    </div>
                <?php endif ?>
            </div>

            <div class="box-body">
                <?php if (!empty($listItems)) : ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="30"
                                class="text-center"><?= Html::checkbox(null, false, ['class' => 'checkAll']) ?></th>
                            <th width="700">Label</th>
                            <th>Nhóm</th>
                            <th class="text-center">Thứ tụ hiển thị</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listItems as $item) : ?>
                            <?php if (!empty($id = Yii::$app->session->getFlash('highlight'))) : ?>
                                <?= ($item['id'] == $id) ? '<tr id="highlight">' : '<tr>' ?>
                            <?php else: ?>
                                <tr>
                            <?php endif ?>
                                <td class="text-center">
                                    <?= Html::checkbox('selected[]', false, ['value' => $item['id'], 'class' => 'check_value']) ?>
                                </td>
                                <td>
                                    <?= $item['icon'] ? '<i class="fa ' . $item['icon'] . '"></i>&nbsp;' : '' ?>
                                    <?= !empty($item['items']) ? Html::a($item['titleByLevel'], null, ['onclick' => "showChild(this)"]) : $item['titleByLevel'] ?>
                                    <?= $item['url'] != null && $item['url'] != '#' ? '&nbsp;&nbsp;<span class="text-muted">' . $item['url'] . '</span>' : '' ?>
                                    <?php if (!empty($item['items'])) : ?>
                                        <span class="has-child pull-right"><i class="fa fa-angle-right"></i></span>
                                        <div class="children">
                                            <ul>
                                                <?php foreach ($item['items'] as $children) : ?>
                                                    <?php if (!empty($children['items'])) : ?>
                                                    <?php if (!empty($id = Yii::$app->session->getFlash('highlight'))) : ?>
                                                        <?= ($children['id'] == $id) ? '<li id="highlight">' : '<li>' ?>
                                                    <?php else: ?>
                                                        <li>
                                                    <?php endif ?>
                                                        <?= Html::a($children['titleByLevel'], null, ['onclick' => "showChild(this)"]) ?>
                                                        <?= $children['url'] != null && $children['url'] != '#' ? '&nbsp;&nbsp;<span class="text-muted">' . $children['url'] . '</span>' : '' ?>
                                                        <span class="action"><?= $this->render('_action_list', ['item' => $children]); ?></span>
                                                        <div class="children">
                                                            <ul>
                                                                <?php foreach ($children['items'] as $childrenMenu) : ?>
                                                                    <?php if (!empty($id = Yii::$app->session->getFlash('highlight'))) : ?>
                                                                        <?= ($childrenMenu['id'] == $id) ? '<li id="highlight">' : '<li>' ?>
                                                                    <?php else: ?>
                                                                        <li>
                                                                    <?php endif ?>
                                                                        <?= $childrenMenu['titleByLevel'] ?>
                                                                        <?= $childrenMenu['url'] != null && $childrenMenu['url'] != '#' ? '&nbsp;&nbsp;<span class="text-muted">' . $childrenMenu['url'] . '</span>' : '' ?>
                                                                        <span class="action">
                                                                            <?= Html::a('<i class="fa fa-chevron-up"></i>', ['change-order', 'id' => $childrenMenu['id'], 'type' => 'up'], ['title' => 'Lên']) ?>
                                                                            <?= Html::a('<i class="fa fa-chevron-down"></i>', ['change-order', 'id' => $childrenMenu['id'], 'type' => 'down'], ['title' => 'Xuống']) ?>
                                                                            <?= $this->render('_action_list', ['item' => $childrenMenu]); ?>
                                                                        </span>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                        </li>
                                                    <?php else: ?>
                                                        <?php if (!empty($id = Yii::$app->session->getFlash('highlight'))) : ?>
                                                            <?= ($children['id'] == $id) ? '<li id="highlight">' : '<li>' ?>
                                                        <?php else: ?>
                                                            <li>
                                                        <?php endif ?>
                                                            <?= $children['titleByLevel'] ?>
                                                            <?= $children['url'] != null && $children['url'] != '#' ? '&nbsp;&nbsp;<span class="text-muted"> ' . $children['url'] . ' </span>' : '' ?>
                                                            <span class="action">
                                                                <?= Html::a('<i class="fa fa-chevron-up"></i>', ['change-order', 'id' => $children['id'], 'type' => 'up'], ['title' => 'Lên']) ?>
                                                                <?= Html::a('<i class="fa fa-chevron-down"></i>', ['change-order', 'id' => $children['id'], 'type' => 'down'], ['title' => 'Xuống']) ?>
                                                                <?= $this->render('_action_list', ['item' => $children]); ?>
                                                            </span>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= $item['menu_group'] ?></td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-chevron-up" aria-hidden="true"></i>', ['change-order', 'id' => $item['id'], 'type' => 'up'], ['title' => 'Lên']) ?>
                                    <?= Html::a('<i class="fa fa-chevron-down" aria-hidden="true"></i>', ['change-order', 'id' => $item['id'], 'type' => 'down'], ['title' => 'Xuống']) ?>
                                </td>
                                <td style="text-align: right">
                                    <?= $this->render('_action_list', ['item' => $item]); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Không có dữ liệu.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

