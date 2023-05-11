<?php

use an602\modules\dashboard\Module;
use an602\widgets\TopMenu;

return [
    'id' => 'dashboard',
    'class' => Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => ['\an602\modules\dashboard\Events', 'onTopMenuInit']],
    ],
    'urlManagerRules' => [
        'dashboard' => 'dashboard/dashboard'
    ]
];
