<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use yii\web\AssetBundle;

/**
 * IE9FixesAsset provides CSS/JS fixes for Internet Explorer 9 versions
 *
 * @see IEFixesAsset for older IE versions
 * @since 1.2
 * @author Luke
 */
class Html5shivAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/html5shiv';

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/html5shiv.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'condition' => 'lt IE 9'
    ];

}
