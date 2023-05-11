<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\queue\helpers;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\queue\Queue;
use an602\modules\queue\interfaces\ExclusiveJobInterface;
use an602\modules\queue\models\QueueExclusive;

/**
 * Queue Helpers
 *
 * @author Luke
 */
class QueueHelper extends BaseObject
{

    public static function isQueued(ExclusiveJobInterface $job)
    {
        $queueExclusive = QueueExclusive::findOne(['id' => $job->getExclusiveJobId()]);
        if ($queueExclusive === null || $queueExclusive->job_status == Queue::STATUS_DONE) {
            return false;
        }

        $jobInQueue = true;
        try {
            if (Yii::$app->queue->isDone($queueExclusive->job_message_id)) {
                $jobInQueue = false;
            }
        } catch (InvalidArgumentException $ex) {
            // not exists
            $jobInQueue = false;
        } catch (InvalidParamException $ex) {
            // not exists
            $jobInQueue = false;
        }

        if (!$jobInQueue) {
            $queueExclusive->delete();
            return false;
        }

        return true;
    }

    public static function markAsQueued($jobQueueId, ExclusiveJobInterface $job)
    {
        $queueExclusive = QueueExclusive::findOne(['id' => $job->getExclusiveJobId()]);
        if ($queueExclusive === null) {
            $queueExclusive = new QueueExclusive();
            $queueExclusive->id = $job->getExclusiveJobId();
        }
        $queueExclusive->job_message_id = $jobQueueId;
        $queueExclusive->save();
    }

}
