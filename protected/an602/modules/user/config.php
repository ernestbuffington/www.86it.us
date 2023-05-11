<?php

use an602\modules\search\engine\Search;
use an602\modules\user\Events;
use an602\commands\IntegrityController;
use an602\modules\content\components\ContentAddonActiveRecord;
use an602\modules\content\components\ContentActiveRecord;
use an602\commands\CronController;
use an602\widgets\TopMenu;

return [
    'id' => 'user',
    'class' => \an602\modules\user\Module::class,
    'isCoreModule' => true,
    'urlManagerRules' => [
        ['class' => 'an602\modules\user\components\UrlRule'],
        'people' => 'user/people',
        '<userContainer>/home' => 'user/profile/home',
        '<userContainer>/about' => 'user/profile/about',
    ],
    'consoleControllerMap' => [
        'user' => 'an602\modules\user\commands\UserController'
    ],
    'events' => [
        ['class' => Search::class, 'event' => Search::EVENT_ON_REBUILD, 'callback' => [Events::class, 'onSearchRebuild']],
        ['class' => ContentActiveRecord::class, 'event' => ContentActiveRecord::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onContentDelete']],
        ['class' => ContentAddonActiveRecord::class, 'event' => ContentAddonActiveRecord::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onContentDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => [Events::class, 'onIntegrityCheck']],
        ['class' => CronController::class, 'event' => CronController::EVENT_ON_HOURLY_RUN, 'callback' => [Events::class, 'onHourlyCron']],
        ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => [Events::class, 'onTopMenuInit']],
    ]
];
?>
