<?php

namespace app\helpers;

use yii\helpers\Html;
use sweelix\yii2\plupload\traits\Plupload;

class HtmlHelper extends Html
{
    use Plupload;
    
    public static function tempalteWithPopover($content, $templateField = true){
        if (!$templateField) {
            return self::a('<i class="fa fa-info-circle"></i>', null, [
                'data-toggle' => 'popover',
                'data-content' => "<div class='content-popover'>$content</div>",
                'tabindex' => 0
            ]);
        }

        return self::a('<i class="fa fa-info-circle"></i>', null, [
            'data-toggle' => 'popover',
            'data-content' => "<div class='content-popover'>$content</div>",
            'tabindex' => 0
        ]).'&nbsp;{label}{input}{hint}{error}';
    }

    /**
     * Generate a hover popover
     * @param $label
     * @param $content
     * @param string $dataPlacement
     * @return string
     */
    public static function generateHoverPopover($label, $content, $dataPlacement = 'top')
    {
        return self::a($label, 'javascript:void(0)', [
            'class' => 'popover-hover',
            'data-content' => $content,
            'rel' => 'popover',
            'data-placement' => $dataPlacement
        ]);
    }
}