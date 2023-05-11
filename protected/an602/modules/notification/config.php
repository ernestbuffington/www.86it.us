<?php

use an602\modules\notification\Module;
use an602\modules\notification\Events;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;
use an602\commands\IntegrityController;
use an602\commands\CronController;
use an602\components\ActiveRecord;
use an602\widgets\LayoutAddons;

return [
    'id' => 'notification',
    'class' => Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onUserDelete']],
        ['class' => Space::class, 'event' => Space::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onSpaceDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => [Events::class, 'onIntegrityCheck']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_DAILY_RUN, 'callback' => [Events::class, 'onCronDailyRun']],
        ['class' => ActiveRecord::class, 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onActiveRecordDelete']],
        ['class' => LayoutAddons::class, 'event' => LayoutAddons::EVENT_BEFORE_RUN, 'callback' => [Events::class, 'onLayoutAddons']]
    ],
];
?>