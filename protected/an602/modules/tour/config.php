<?php

use an602\modules\dashboard\widgets\Sidebar;
use an602\modules\tour\Module;

return [
    'id' => 'tour',
    'class' => Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => Sidebar::class, 'event' => Sidebar::EVENT_INIT, 'callback' => [Module::class, 'onDashboardSidebarInit']],
    ],
];
