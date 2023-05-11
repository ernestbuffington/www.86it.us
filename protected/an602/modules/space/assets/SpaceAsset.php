<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\assets;

use an602\components\assets\AssetBundle;

class SpaceAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@space/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.space.js'
    ];
}
