<?php

use an602\modules\file\Module;
use an602\modules\search\engine\Search;
use an602\modules\content\widgets\WallEntryAddons;
use an602\commands\CronController;
use an602\commands\IntegrityController;
use an602\modules\file\Events;
use an602\modules\user\models\User;
use an602\components\ActiveRecord;

return [
    'id' => 'file',
    'class' => Module::class,
    'isCoreModule' => true,
    'consoleControllerMap' => [
        'file' => 'an602\modules\file\commands\FileController'
    ],
    'events' => [
        ['class' => WallEntryAddons::class, 'event' => WallEntryAddons::EVENT_INIT, 'callback' => [Events::class, 'onWallEntryAddonInit']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_DAILY_RUN, 'callback' => [Events::class, 'onCronDailyRun']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => [Events::class, 'onIntegrityCheck']],
        ['class' => ActiveRecord::class, 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onBeforeActiveRecordDelete']],
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onUserDelete']],
        ['class' => Search::class, 'event' => Search::EVENT_SEARCH_ATTRIBUTES, 'callback' => [Events::class, 'onSearchAttributes']]
    ],
];
