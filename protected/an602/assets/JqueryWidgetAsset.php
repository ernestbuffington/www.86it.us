<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;

/**
 * jquery-ui-widget
 *
 * @author luke
 */
class JqueryWidgetAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-ui';

    /**
     * @inheritdoc
     */
    public $js = ['ui/minified/widget.js'];

}
