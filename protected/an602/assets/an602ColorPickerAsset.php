<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\WebStaticAssetBundle;

/**
 * Color Picker js utility
 *
 * @author buddha
 */
class an602ColorPickerAsset extends WebStaticAssetBundle
{
    /**
     * @inheritdoc
     */
    public $js = ['js/an602/an602.ui.colorpicker.js'];

    public $depends = [BootstrapColorPickerAsset::class];

}
