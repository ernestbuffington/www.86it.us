<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

return [
    'yii\bootstrap\BootstrapPluginAsset' => [
        'depends' => [
            'yii\web\JqueryAsset',
            'yii\bootstrap\BootstrapAsset',
            'an602\assets\JuiBootstrapBridgeAsset'
        ]
    ],
    'yii\web\JqueryAsset' => [
        'sourcePath' => '@npm/jquery/dist',
    ],
    'yii\jui\JuiAsset' => [
        'sourcePath' => '@npm/jquery-ui/dist'
    ],
];
