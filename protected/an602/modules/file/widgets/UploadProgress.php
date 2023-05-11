<?php

namespace an602\modules\file\widgets;

use yii\helpers\Html;

/**
 * UploadButtonWidget renders an upload button with integrated file input.
 * 
 * @package an602.modules_core.file.widgets
 * @since 1.2
 */
class UploadProgress extends \an602\widgets\JsWidget
{
    
    public $jsWidget = "ui.progress.Progress";
    
    public $visible = false;
    
    public function getAttributes()
    {
        return [
            'style' => 'margin:10px 0px'
        ];
    }

}
