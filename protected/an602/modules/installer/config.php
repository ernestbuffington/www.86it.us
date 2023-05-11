<?php

use an602\modules\installer\Events;
use yii\db\Connection;

return [
    'id' => 'installer',
    'class' => an602\modules\installer\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => Connection::class, 'event' => Connection::EVENT_AFTER_OPEN, 'callback' => [Events::class, 'onConnectionAfterOpen']],
    ],
];
?>