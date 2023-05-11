<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use yii\web\AssetBundle;

/**
 * jquery-caretjs.js
 *
 * @author buddha
 */
class CaretjsAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/caret.js';

    /**
     * @inheritdoc
     */
    public $js = ['dist/jquery.caret.min.js'];
}
