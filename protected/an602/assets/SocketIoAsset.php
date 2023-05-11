<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use yii\web\AssetBundle;

/**
 * Socket.IO client files
 *
 * @since 1.3
 * @author luke
 */
class SocketIoAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/socket.io-client';

    /**
     * @inheritdoc
     */
    public $js = ['dist/socket.io.slim.js'];

}
