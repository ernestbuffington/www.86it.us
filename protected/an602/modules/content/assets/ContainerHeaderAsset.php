<?php

namespace an602\modules\content\assets;

use yii\web\AssetBundle;

class ContainerHeaderAsset extends AssetBundle
{
    public $sourcePath = '@content/resources';

    public $js = [
        'js/an602.content.container.Header.js'
    ];
}
