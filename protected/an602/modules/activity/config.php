<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\commands\CronController;
use an602\modules\activity\Events;
use an602\components\ActiveRecord;
use an602\commands\IntegrityController;
use an602\modules\activity\Module;
use an602\modules\admin\widgets\SettingsMenu;
use an602\modules\user\widgets\AccountMenu;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'activity',
    'class' => Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => ActiveRecord::class, 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onActiveRecordDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => [Events::class, 'onIntegrityCheck']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_HOURLY_RUN, 'callback' => [Events::class, 'onCronHourlyRun']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_DAILY_RUN, 'callback' => [Events::class, 'onCronDailyRun']],
        ['class' => AccountMenu::class, 'event' => AccountMenu::EVENT_INIT, 'callback' => [Events::class, 'onAccountMenuInit']],
        ['class' => SettingsMenu::class, 'event' => SettingsMenu::EVENT_INIT, 'callback' => [Events::class, 'onSettingsMenuInit']]
    ],
];
