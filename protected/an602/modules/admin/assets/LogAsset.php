<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\assets;

use yii\web\AssetBundle;
use yii\web\View;

class LogAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@admin/resources';

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_END
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.admin.log.js'
    ];

}
