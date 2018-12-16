<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;

?>
<?php if ($isViewAs): ?>
    <div class="content-header">
        <?php
        $js = '
                            $(\'select[name="viewAsId"]\').on("change", function (e) {
                                 var userId = $(\'select[name="viewAsId"] option:selected\').val();
                                 window.location = "/permission/permission/view-as?id=" + userId;
                            });
                         ';
        $this->registerJs($js, $this::POS_END);
        ?>
        <div class="view-as navbar navbar-inner" style="
             margin-bottom: 0px;
             clear: both;
             width: 100%;
             display: block;
             border: 1px solid #ccc;
             background: #fff;
             padding: 5px 10px;
             background-color: #f39c12;
             ">
            <form class="form-horizontal">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="col-sm-2 control-label" style="width: auto;"><i class="fa fa-warning text-red"></i> Xem trang như thành viên: </label>
                    <div class="col-sm-6">
                        <?=
                        Select2::widget([
                            'name' => 'viewAsId',
                            'value' => Yii::$app->user->identity->fullname,
                            'options' => [
                                'placeholder' => 'Select user...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'ajax' => [
                                    'url' => Url::to(['/user/user/list-user']),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(user) { return user.text; }'),
                                'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2 control-bu">
                        <?= Html::a('Reset', Url::to(['/permission/permission/reset', 'redirect' => Yii::$app->request->url]), ['class' => 'btn btn-default']) ?>
                    </div>
                </div><!-- /.box-body -->
            </form>
        </div>
    </div>
<?php endif; ?>