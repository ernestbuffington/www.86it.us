<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;
use an602\modules\ui\view\components\View;

/**
 * bluebird promis library
 *
 * @author luke
 */
class BluebirdAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $defaultDepends = false;

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
    public $sourcePath = '@npm/bluebird';

    /**
     * @inheritdoc
     */
    public $js = ['js/browser/bluebird.min.js'];
}
