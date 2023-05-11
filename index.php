<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/protected/vendor/autoload.php');
require(__DIR__ . '/protected/vendor/yiisoft/yii2/Yii.php');


$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/protected/an602/config/common.php'),
    require(__DIR__ . '/protected/an602/config/web.php'),
    (is_readable(__DIR__ . '/protected/config/dynamic.php')) ? require(__DIR__ . '/protected/config/dynamic.php') : [],
    require(__DIR__ . '/protected/config/common.php'),
    require(__DIR__ . '/protected/config/web.php')
);

(new an602\components\Application($config))->run();
