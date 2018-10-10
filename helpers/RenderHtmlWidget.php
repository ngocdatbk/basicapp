<?php

namespace app\helpers;

use Yii;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\helpers\Html;

class RenderHtmlWidget
{
    public static function renderDateRangePicker($attribute, $options = [])
    {
        if (!isset($options['format'])) {
            $options['format'] = 'd-m-Y';
        }

        return
            '<div class="input-group drp-container">'
            . DateRangePicker::widget([
                'name' => $attribute,
                'useWithAddon' => true,
                'convertFormat' => true,
                'startAttribute' => $attribute . '[from_date]',
                'endAttribute' => $attribute . '[to_date]',
                'startInputOptions' => ['value' => isset($options['startInputOptions']) ? $options['startInputOptions'] : ''],
                'endInputOptions' => ['value' => isset($options['endInputOptions']) ? $options['endInputOptions'] : ''],
                'pluginOptions' => [
                    'locale' => ['format' => $options['format']],
                ]
            ])
            . '</div>';
    }

    public static function renderSelect2WithAjax($attribute, $options = [])
    {
        return Select2::widget([
            'name' => $attribute,
            'value' => isset($options['value']) ? $options['value'] : [],
            'initValueText' => isset($options['initValueText']) ? $options['initValueText'] : [],
            'options' => [
                'placeholder' => '',
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => isset($options['url']) ? $options['url'] : '',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(company) { return company.text; }'),
                'templateSelection' => new JsExpression('function (company) { return company.text; }'),
                'tags' => false,
            ]
        ]);
    }

    public static function renderSelect2($attribute, $options = [])
    {
        return Select2::widget([
            'name' => $attribute,
            'value' => isset($options['value']) ? $options['value'] : [],
            'data' => $options['data'] ? $options['data'] : [],
            'options' => [
                'placeholder' => '',
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => false,
            ]
        ]);
    }

    public static function renderInputText($attributes, $options = [])
    {
        return Html::textInput($attributes, isset($options['value']) ? $options['value'] : '',
            ['class' => 'form-control']);
    }

    public static function renderDropdown($attributes, $options = [])
    {
        return Html::dropDownList(
            $attributes,
            isset($options['value']) ? $options['value'] : null,
            isset($options['items']) ? $options['items'] : [],
            ['class' => 'form-control', 'prompt' => '',]
        );
    }
}