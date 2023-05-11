<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;
use yii\web\View;

/**
 * AppDynamicAsset provides assets which are included in the core layout.
 * It similar to AppAsset but won't be compressed and combined.
 * So it can handle dynamic assets (e.g. javascript locales)
 *
 * @since 1.2
 */
class AppDynamicAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $defer = false;

    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public $depends = [
        JqueryTimeAgoLocaleAsset::class
    ];

}
