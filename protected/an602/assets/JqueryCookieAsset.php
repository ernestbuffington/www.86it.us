<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use yii\web\AssetBundle;

/**
 * jquery-cookie
 *
 * @author buddha
 */
class JqueryCookieAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/jquery.cookie';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.cookie.js'];

}
