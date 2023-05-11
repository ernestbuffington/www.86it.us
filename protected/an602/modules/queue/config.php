<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */
use an602\commands\CronController;
use an602\modules\queue\Events;
use an602\modules\queue\Module;
use yii\queue\Queue;

return [
    'id' => 'queue',
    'class' => Module::class,
    'isCoreModule' => true,
    'events' => [
        [CronController::class, CronController::EVENT_ON_DAILY_RUN, [Events::class, 'onCronRun']],
        [Queue::class, Queue::EVENT_AFTER_ERROR, [Events::class, 'onQueueError']],
        [Queue::class, Queue::EVENT_BEFORE_PUSH, [Events::class, 'onQueueBeforePush']],
        [Queue::class, Queue::EVENT_AFTER_PUSH, [Events::class, 'onQueueAfterPush']]
    ],
];
