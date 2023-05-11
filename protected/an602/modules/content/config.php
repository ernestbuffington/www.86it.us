<?php

use an602\commands\CronController;
use an602\modules\content\Events;
use an602\commands\IntegrityController;
use an602\modules\content\widgets\WallEntryAddons;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;
use an602\modules\search\engine\Search;
use an602\modules\content\components\ContentActiveRecord;

return [
    'id' => 'content',
    'class' => \an602\modules\content\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => [Events::class, 'onIntegrityCheck']],
        ['class' => WallEntryAddons::class, 'event' => WallEntryAddons::EVENT_INIT, 'callback' => [Events::class, 'onWallEntryAddonInit']],
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onUserDelete']],
        ['class' => User::class, 'event' => User::EVENT_BEFORE_SOFT_DELETE, 'callback' => [Events::class, 'onUserSoftDelete']],
        ['class' => Space::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onSpaceDelete']],
        ['class' => Search::class, 'event' => Search::EVENT_ON_REBUILD, 'callback' => [Events::class, 'onSearchRebuild']],
        ['class' => ContentActiveRecord::class, 'event' => ContentActiveRecord::EVENT_AFTER_INSERT, 'callback' => [Events::class, 'onContentActiveRecordSave']],
        ['class' => ContentActiveRecord::class, 'event' => ContentActiveRecord::EVENT_AFTER_UPDATE, 'callback' => [Events::class, 'onContentActiveRecordSave']],
        ['class' => ContentActiveRecord::class, 'event' => ContentActiveRecord::EVENT_AFTER_DELETE, 'callback' => [Events::class, 'onContentActiveRecordDelete']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_DAILY_RUN, 'callback' => [Events::class, 'onCronDailyRun']],
        ['class' => CronController::class, 'event' => CronController::EVENT_BEFORE_ACTION, 'callback' => [Events::class, 'onCronBeforeAction']]
    ],
];