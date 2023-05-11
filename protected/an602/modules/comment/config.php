<?php

use an602\modules\comment\Events;
use an602\modules\user\models\User;
use an602\modules\content\components\ContentActiveRecord;
use an602\commands\IntegrityController;
use an602\modules\content\widgets\WallEntryAddons;
use an602\modules\content\widgets\WallEntryLinks;
use an602\modules\search\engine\Search;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'comment',
    'class' => \an602\modules\comment\Module::class,
    'isCoreModule' => true,
    'events' => [
        [User::class, User::EVENT_BEFORE_DELETE, [Events::class, 'onUserDelete']],
        [ContentActiveRecord::class, ContentActiveRecord::EVENT_BEFORE_DELETE, [Events::class, 'onContentDelete']],
        [IntegrityController::class, IntegrityController::EVENT_ON_RUN, [Events::class, 'onIntegrityCheck']],
        [WallEntryLinks::class, WallEntryLinks::EVENT_INIT, [Events::class, 'onWallEntryLinksInit']],
        [WallEntryAddons::class, WallEntryAddons::EVENT_INIT, [Events::class, 'onWallEntryAddonInit']],
        [Search::class, Search::EVENT_SEARCH_ATTRIBUTES, [Events::class, 'onSearchAttributes']]
    ],
];
