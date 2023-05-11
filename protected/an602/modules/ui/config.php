<?php

use an602\components\console\Application;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'ui',
    'class' => \an602\modules\ui\Module::class,
    'consoleControllerMap' => [
        'theme' => '\an602\modules\ui\commands\ThemeController'
    ],
    'isCoreModule' => true
];
