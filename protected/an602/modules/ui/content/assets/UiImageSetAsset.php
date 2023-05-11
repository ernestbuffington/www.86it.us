<?php

namespace an602\modules\ui\content\assets;

use yii\web\AssetBundle;

class UiImageSetAsset extends AssetBundle
{
    public $sourcePath = '@ui/content/resources';

    public $js = [
        'js/an602.ui.imageset.js'
    ];

    public $css = [
        'css/an602.ui.imageset.css'
    ];
}
