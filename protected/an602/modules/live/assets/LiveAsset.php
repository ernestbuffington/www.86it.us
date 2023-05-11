<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live\assets;

use an602\components\assets\AssetBundle;

class LiveAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@live/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.live.js',
        'js/an602.live.poll.js',
    ];
}
