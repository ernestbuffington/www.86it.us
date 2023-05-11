<?php

use an602\modules\live\Events;
use an602\modules\space\models\Membership;
use an602\modules\friendship\models\Friendship;
use an602\modules\user\models\Follow;
use an602\commands\CronController;

return [
    'id' => 'live',
    'class' => an602\modules\live\Module::class,
    'isCoreModule' => true,
    'events' => [
        [Membership::class, Membership::EVENT_MEMBER_ADDED, [Events::class, 'onMemberEvent']],
        [Membership::class, Membership::EVENT_MEMBER_REMOVED, [Events::class, 'onMemberEvent']],
        [Friendship::class, Friendship::EVENT_FRIENDSHIP_CREATED, [Events::class, 'onFriendshipEvent']],
        [Friendship::class, Friendship::EVENT_FRIENDSHIP_REMOVED, [Events::class, 'onFriendshipEvent']],
        [Follow::class, Follow::EVENT_FOLLOWING_CREATED, [Events::class, 'onFollowEvent']],
        [Follow::class, Follow::EVENT_FOLLOWING_REMOVED, [Events::class, 'onFollowEvent']],
        [CronController::class, CronController::EVENT_ON_HOURLY_RUN, [Events::class, 'onHourlyCronRun']]
    ],
];
?>