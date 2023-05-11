<?php

/**
 * Application configuration for api tests
 */
$testConfig = [
    'class' => 'an602\components\Application',
    'components' => [
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
        ],
    ],
];

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(dirname(__DIR__)))));

return yii\helpers\ArrayHelper::merge(
                // Common Config
                require(YII_APP_BASE_PATH . '/an602/config/common.php'),
                // Web Config
                require(YII_APP_BASE_PATH . '/an602/config/web.php'),
                // Test Common Config
                require(__DIR__ . '/config.php'),
                // API Test Config
                $testConfig
);
