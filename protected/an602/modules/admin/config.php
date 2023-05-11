<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\dashboard\widgets\Sidebar;
use an602\modules\admin\Events;
use an602\commands\CronController;
use an602\modules\user\components\User;

return [
    'id' => 'admin',
    'class' => \an602\modules\admin\Module::class,
    'isCoreModule' => true,
    'events' => [
        [
            'class' => User::class,
            'event' => User::EVENT_BEFORE_SWITCH_IDENTITY,
            'callback' => [
                Events::class,
                'onSwitchUser'
            ]
        ],
        [
            'class' => Sidebar::class,
            'event' => Sidebar::EVENT_INIT,
            'callback' => [
                Events::class,
                'onDashboardSidebarInit'
            ]
        ],
        [
            'class' => CronController::class,
            'event' => CronController::EVENT_ON_DAILY_RUN,
            'callback' => [
                Events::class,
                'onCronDailyRun'
            ]
        ]
    ],
];
