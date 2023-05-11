<?php

use an602\components\ActiveRecord;
use an602\commands\IntegrityController;
use an602\modules\like\Module;
use an602\modules\user\models\User;
use an602\modules\content\widgets\WallEntryLinks;

return [
    'id' => 'like',
    'class' => an602\modules\like\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => ['an602\modules\like\Events', 'onUserDelete']],
        ['class' => ActiveRecord::class, 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => ['an602\modules\like\Events', 'onActiveRecordDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => ['an602\modules\like\Events', 'onIntegrityCheck']],
        ['class' => WallEntryLinks::class, 'event' => WallEntryLinks::EVENT_INIT, 'callback' => ['an602\modules\like\Events', 'onWallEntryLinksInit']],
    ],
];
?>