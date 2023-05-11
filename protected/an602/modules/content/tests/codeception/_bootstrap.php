<?php
/**
 * This is the initial test bootstrap, which will load the default test bootstrap from the an602 core
 */
// Parse the environment arguments (Note: only simple --env ENV is supported no comma sepration merge...)
$env = isset($GLOBALS['env']) ? $GLOBALS['env'] : [];

// If environment was set try loading special environment config else load default
if (count($env) > 0) {
    \Codeception\Configuration::append(['environment' => $env]);


    $envCfgFile = dirname(__DIR__) . '/config/env/test.' . $env[0][0] . '.php';

    if (file_exists($envCfgFile)) {
        $cfg = array_merge(require_once(__DIR__ . '/../config/test.php'), require_once($envCfgFile));
    }
}

// If no environment is set we have to load the default config
if (!isset($cfg)) {
    $cfg = require_once(__DIR__ . '/../config/test.php');
}

// If no an602_root is given we assume our module is in the a root to be in /protected/an602/modules/<module>/tests/codeception directory
$cfg['an602_root'] = isset($cfg['an602_root']) ? $cfg['an602_root'] : dirname(__DIR__) . '/../../../../..';


// Load default test bootstrap
require_once($cfg['an602_root'] . '/protected/an602/tests/codeception/_bootstrap.php');

// Overwrite the default test alias
Yii::setAlias('@tests', dirname(__DIR__));
Yii::setAlias('@env', '@tests/config/env');
Yii::setAlias('@root', $cfg['an602_root']);
Yii::setAlias('@an602Tests', $cfg['an602_root'] . '/protected/an602/tests');

// Load all supporting test classes needed for test execution
\Codeception\Util\Autoload::addNamespace('', Yii::getAlias('@an602Tests/codeception/_support'));
\Codeception\Util\Autoload::addNamespace('tests\codeception\fixtures', Yii::getAlias('@an602Tests/codeception/fixtures'));
\Codeception\Util\Autoload::addNamespace('', Yii::getAlias('@an602Tests/codeception/_pages'));
if(isset($cfg['modules'])) {
    \Codeception\Configuration::append(['an602_modules' => $cfg['modules']]);
}

if(isset($cfg['fixtures'])) {
    \Codeception\Configuration::append(['fixtures' => $cfg['fixtures']]);
}
?>