<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\assets;

use an602\components\assets\AssetBundle;
use an602\modules\ui\view\components\View;

/**
 * Fle related assets.
 *
 * @since 1.2
 * @author buddha
 */
class FileAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $defer = false;

    /**
     * @inheritdoc
     */
    public $jsPosition = View::POS_HEAD;

    /**
     * @inheritdoc
     */
    public $sourcePath = '@file/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.file.js'
    ];
}
