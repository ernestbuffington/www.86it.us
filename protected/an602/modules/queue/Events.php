<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\queue;

use Yii;
use yii\base\BaseObject;
use yii\base\Event;
use yii\queue\ExecEvent;
use yii\queue\PushEvent;
use an602\modules\queue\jobs\CleanupExclusiveJobs;
use an602\modules\queue\interfaces\ExclusiveJobInterface;
use an602\modules\queue\helpers\QueueHelper;

/**
 * Events provides callbacks to handle events.
 *
 * @since 1.3
 * @author luke
 */
class Events extends BaseObject
{

    /**
     * Cron call back
     *
     * @param Event $event
     */
    public static function onCronRun(Event $event)
    {
        //Yii::$app->queue->push(new CleanupExclusiveJobs());
    }

    /**
     * Callback for errors while queue execution
     *
     * @param ExecEvent $event
     */
    public static function onQueueError(ExecEvent $event)
    {
        /* @var $exception \Expection */
        $exception = $event->error;
        Yii::error('Could not execute queued job! Message: ' . $exception->getMessage() . ' Trace:' . $exception->getTraceAsString(), 'queue');
    }

    /**
     * Callback before new jobs in the queue.
     * Handles exclusive jobs.
     *
     * @param PushEvent $event
     */
    public static function onQueueBeforePush(PushEvent $event)
    {
        if ($event->job instanceof ExclusiveJobInterface) {
            // Do not add exclusive jobs if already exists in queue
            if (QueueHelper::isQueued($event->job)) {
                $event->handled = true;
            }
        }
    }

    /**
     * Callback after new jobs in the queue.
     * Handles exclusive jobs.
     *
     * @param PushEvent $event
     */
    public static function onQueueAfterPush(PushEvent $event)
    {
        if ($event->job instanceof ExclusiveJobInterface) {
            QueueHelper::markAsQueued($event->id, $event->job);
        }
    }

}
