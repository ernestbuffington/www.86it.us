<?php

use an602\widgets\TopMenuRightStack;
use an602\modules\search\Events;
use an602\components\console\Application;
use an602\commands\CronController;

return [
    'isCoreModule' => true,
    'id' => 'search',
    'class' => \an602\modules\search\Module::class,
    'events' => [
        ['class' => TopMenuRightStack::class, 'event' => TopMenuRightStack::EVENT_INIT, 'callback' => [Events::class, 'onTopMenuRightInit']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_HOURLY_RUN, 'callback' => [Events::class, 'onHourlyCron']],
    ],
    'consoleControllerMap' => [
        'search' => '\an602\modules\search\commands\SearchController'
    ],
    'urlManagerRules' => [
        'search' => 'search/search/index',
    ]
];
