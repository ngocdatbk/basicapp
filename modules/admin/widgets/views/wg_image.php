<?php

use yii\helpers\Html;
?>
<div class="form-group" id="<?= $fieldAdderOptions['id'] ?>">
    <label class="control-label" for="image"><?= Yii::t('admin.product', 'Images') ?></label>
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $key => $image): ?>
            <div class="<?= $fieldAdderOptions['sourcElementClass'] ?> multiple-select-holder" id="image" style="margin-bottom:3px">
                <?= Html::input('file', 'image[' . $key . '][value]', $image['value'], ['class' => 'form-control']); ?>
                <span class="input-group-addon">
                    <?= Html::radio('image[' . $key . '][is_primary]', isset($image['is_primary']) && $image['is_primary'], ['value' => 1, 'data-group-id' => $fieldAdderOptions['id']]); ?>
                </span>
                <a class="input-group-addon FieldRemover" data-source="div.input-group" data-minfields="1" type="button" tabindex="-1" data-action="removeImage">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="<?= $fieldAdderOptions['sourcElementClass'] ?> multiple-select-holder" style="margin-bottom:3px">        
            <?= Html::input('file', 'image[0][value]', '', ['class' => 'form-control']); ?>
            <span class="input-group-addon">
                <?= Html::radio('image[0][is_primary]', false, ['value' => 1, 'data-group-id' => $fieldAdderOptions['id']]); ?>
            </span>
            <a class="input-group-addon FieldRemover" data-source="div.input-group" data-minfields="1" type="button" tabindex="-1" data-action="removeImage">
                <i class="glyphicon glyphicon-remove"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
<div class="form-group">
    <a data-action="addImage" class="btn btn-default btn-xs addImage FieldAdder" data-source="<?= $fieldAdderOptions['tag'] ?>#<?= $fieldAdderOptions['id'] ?> <?= $fieldAdderOptions['sourcElementTag'] ?>.<?= $fieldAdderOptions['sourcElementClass'] ?>" type="button" tabindex="-1"><span class="glyphicon glyphicon-plus"></span> Thêm</a>
</div>