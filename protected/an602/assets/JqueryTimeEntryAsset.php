<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * TimeAgo Asset Bundle
 *
 * @author luke
 */
class JqueryTimeEntryAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => false
    ];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/kbw.timeentry';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.plugin.js', 'jquery.timeentry.js'];

    /**
     * @inheritdoc
     */
    public $css = ['jquery.timeentry.css'];

}
