<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;

/**
 * jquery-autosize
 *
 * @author buddha
 */
class JqueryAutosizeAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/jquery-autosize';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.autosize.min.js'];
}
