<?php

use an602\commands\IntegrityController;
use an602\modules\post\Events;

return [
    'id' => 'post',
    'class' => \an602\modules\post\Module::class,
    'isCoreModule' => true,
    'events' => [
        [IntegrityController::class, IntegrityController::EVENT_ON_RUN, [Events::class, 'onIntegrityCheck']],
    ]
];