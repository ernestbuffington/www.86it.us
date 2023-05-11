<?php

use an602\modules\friendship\Events;
use an602\modules\user\widgets\AccountMenu;

return [
    'id' => 'friendship',
    'class' => \an602\modules\friendship\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => AccountMenu::class, 'event' => AccountMenu::EVENT_INIT, 'callback' => [Events::class, 'onAccountMenuInit']],
    ]
];
?>