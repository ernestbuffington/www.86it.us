<?php

use an602\modules\search\engine\Search;
use an602\modules\user\models\User;
use an602\modules\space\Events;
use an602\modules\space\Module;
use an602\commands\IntegrityController;
use an602\widgets\TopMenu;

return [
    'id' => 'space',
    'class' => Module::class,
    'isCoreModule' => true,
    'urlManagerRules' => [
        ['class' => 'an602\modules\space\components\UrlRule'],
        'spaces' => 'space/spaces',
        '<spaceContainer>/home' => 'space/space/home',
        '<spaceContainer>/about' => 'space/space/about',
    ],
    'modules' => [
        'manage' => [
            'class' => 'an602\modules\space\modules\manage\Module'
        ],
    ],
    'consoleControllerMap' => [
        'space' => 'an602\modules\space\commands\SpaceController'
    ],
    'events' => [
        [User::class, User::EVENT_BEFORE_SOFT_DELETE, [Events::class, 'onUserSoftDelete']],
        [Search::class, Search::EVENT_ON_REBUILD, [Events::class, 'onSearchRebuild']],
        [IntegrityController::class, IntegrityController::EVENT_ON_RUN, [Events::class, 'onIntegrityCheck']],
        [TopMenu::class, TopMenu::EVENT_INIT, [Events::class, 'onTopMenuInit']],
    ],
];
