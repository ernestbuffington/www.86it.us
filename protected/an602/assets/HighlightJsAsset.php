<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\assets;

use an602\components\assets\WebStaticAssetBundle;

class HighlightJsAsset extends WebStaticAssetBundle
{

    /**
     * @inheritdoc
     */
    public $js = ['js/highlight.js/highlight.pack.js'];

    /**
     * @inheritdoc
     */
    public $depends = [
        HighlightJsStyleAsset::class
    ];
}
