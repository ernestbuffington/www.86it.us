<?php

/*
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

/**
 * This file is executed before the _bootstrap file and loads the an602 test config
 * test.php by means of the env settings.
 */

use Codeception\Configuration;

$codeceptConfig = Configuration::config();

$testRoot = $codeceptConfig['test_root'];
$an602Root = $codeceptConfig['an602_root'];

// Parse the environment arguments
$env = $GLOBALS['env'] ?? [];

// If an environment was set try loading special environment config else load default config
if (count($env) > 0) {
    Configuration::append(['environment' => $env]);

    /** @noinspection ForgottenDebugOutputInspection */
    print_r('Run execution environment: ' . $env[0]);

    $envCfgFile = $testRoot . '/config/env/' . $env[0] . '/test.php';

    if (file_exists($envCfgFile)) {
        $cfg = array_merge(require($testRoot . '/config/test.php'), require($envCfgFile));
    }
}

// If no environment is set we have to load the default config
if (!isset($cfg)) {
    $cfg = require($testRoot . '/config/test.php');
}

// We prefer the system environment setting over the configuration
if ($an602Root) {
    $cfg['an602_root'] = $an602Root;
} else {
    // If no an602_root is given we assume to be in /protected/an602/modules/<module>/tests/codeception directory
    $cfg['an602_root'] ??= $testRoot . '../../../../';
}

// Set some configurations and overwrite the an602_root
if (isset($cfg['modules'])) {
    Configuration::append(['an602_modules' => $cfg['modules']]);
}

if (isset($cfg['an602_root'])) {
    Configuration::append(['an602_root' => $cfg['an602_root']]);
}

if (isset($cfg['fixtures'])) {
    Configuration::append(['fixtures' => $cfg['fixtures']]);
}

return $cfg;
