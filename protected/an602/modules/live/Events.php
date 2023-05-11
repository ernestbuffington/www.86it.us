<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live;

use Yii;
use an602\modules\live\Module;
use an602\modules\friendship\FriendshipEvent;
use an602\modules\space\MemberEvent;
use an602\modules\user\events\FollowEvent;
use an602\modules\content\components\ContentContainerActiveRecord;

/**
 * Events provides callbacks to handle events.
 * 
 * @since 1.2
 * @author luke
 */
class Events extends \yii\base\BaseObject
{

    /**
     * On hourly cron job, add database cleanup task
     */
    public static function onHourlyCronRun()
    {
        Yii::$app->queue->push(new jobs\DatabaseCleanup());
    }

    /**
     * MemberEvent is called when a user left or joined a space
     * Used to clear the cache legitimate cache.
     */
    public static function onMemberEvent(MemberEvent $event)
    {
        Yii::$app->getModule('live')->refreshLegitimateContentContainerIds($event->user);
    }

    /**
     * FriendshipEvent is called when a friendship was created or removed
     * Used to clear the cache legitimate cache.
     */
    public static function onFriendshipEvent(FriendshipEvent $event)
    {
        Yii::$app->getModule('live')->refreshLegitimateContentContainerIds($event->user1);
        Yii::$app->getModule('live')->refreshLegitimateContentContainerIds($event->user2);
    }

    /**
     * FollowEvent is called when a following was created or removed
     * Used to clear the cache legitimate cache.
     */
    public static function onFollowEvent(FollowEvent $event)
    {
        if ($event->target instanceof ContentContainerActiveRecord) {
            Yii::$app->getModule('live')->refreshLegitimateContentContainerIds($event->user);
        }
    }

}
