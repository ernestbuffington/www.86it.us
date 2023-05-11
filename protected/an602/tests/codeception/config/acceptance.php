<?php

/**
 * Application configuration for acceptance tests
 */
$testConfig = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'test'
        ],
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
        ],
    ],
    'params' => [
        'dynamicConfigFile' => '@an602/tests/codeception/config/dynamic.php',
        'installed' => true,
        'settings' => [
            'core' => [
                'name' => 'an602 Test',
                'baseUrl' => 'http://localhost:8080',
            ]
        ],
        'enablePjax' => true
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
                // Acceptance Test Config
                $testConfig
);
