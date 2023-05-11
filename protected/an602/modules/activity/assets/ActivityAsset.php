<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\assets;

use an602\components\assets\AssetBundle;
use an602\modules\stream\assets\StreamAsset;

class ActivityAsset extends AssetBundle
{

    public $sourcePath = '@activity/resources';

    public $js = [
        'js/an602.activity.js'
    ];

    public $depends = [
        StreamAsset::class
    ];

}
