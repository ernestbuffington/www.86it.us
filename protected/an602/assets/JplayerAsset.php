<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use yii\web\AssetBundle;

/**
 * jquery-At.js
 *
 * @author buddha
 */
class JplayerAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/jplayer/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'jplayer/jquery.jplayer.js',
        'add-on/jplayer.playlist.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = ['skin/blue.monday/css/jplayer.blue.monday.min.css'];

}
