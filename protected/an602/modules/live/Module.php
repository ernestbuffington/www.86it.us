<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live;

use an602\modules\space\models\Space;
use Yii;
use an602\modules\content\models\Content;
use an602\modules\user\models\User;
use an602\modules\user\models\Follow;
use an602\modules\friendship\models\Friendship;
use an602\modules\space\models\Membership;
use yii\db\Query;

/**
 * Live module provides a live channel to the users browser.
 *
 * @since 1.2
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdoc
     */
    public $isCoreModule = true;

    /**
     * @var string cache prefix for legitimate content container ids by user
     */
    public static $legitimateCachePrefix = 'live.contentcontainerId.legitmation.';

    /**
     * @var bool Activity flag, useful for JS config
     */
    public $isActive = true;

    /**
     * Returns an array of content container ids which belongs to the given user.
     *
     * There are three separeted lists by visibility level:
     *  - Content::VISIBILITY_PUBLIC [1,2,3,4]   (Public visibility only)
     *  - Content::VISIBILITY_PRIVATE [5,6,7]    (Public and private visibility)
     *  - Content::VISIBILITY_OWNER (10)         (No visibility, direct to the user)
     *
     * @param User $user the User
     * @param boolean $cached use caching
     * @return array multi dimensional array of user content container ids
     */
    public function getLegitimateContentContainerIds(User $user, $cached = true)
    {
        $legitimation = Yii::$app->cache->get(self::$legitimateCachePrefix . $user->id);

        if (!$cached || $legitimation === false) {
            $legitimation = [
                Content::VISIBILITY_PUBLIC => [],
                Content::VISIBILITY_PRIVATE => [],
                Content::VISIBILITY_OWNER => [],
            ];

            // When no content container record exists (yet)
            // This may happen during the registration process
            if ($user->contentContainerRecord === null) {
                return $legitimation;
            }

            // Add users own content container
            $legitimation[Content::VISIBILITY_OWNER][] = $user->contentContainerRecord->id;

            // Add member space container of the user
            $privateContainerQuery = Membership::getMemberSpaceContainerIdQuery($user);

            // Add friend container if friendship module is active
            if (Yii::$app->getModule('friendship')->getIsEnabled()) {
                $privateContainerQuery->union(Friendship::getFriendshipContainerIdQuery($user), true);
            }

            foreach ($privateContainerQuery->all() as $id => $value) {
                $legitimation[Content::VISIBILITY_PRIVATE][] = $id;
            }

            // User sees public content of spaces and profiles the users follows
            foreach (Follow::getFollowedContainerIdQuery($user)->all() as $id => $value) {
                $legitimation[Content::VISIBILITY_PUBLIC][] = $id;
            }

            Yii::$app->cache->set(self::$legitimateCachePrefix . $user->id, $legitimation);
            Yii::$app->live->driver->onContentContainerLegitimationChanged($user, $legitimation);
        }

        return $legitimation;
    }

    public function refreshLegitimateContentContainerIds(User $user)
    {
        Yii::$app->cache->delete(self::$legitimateCachePrefix . $user->id);
        $this->getLegitimateContentContainerIds($user);
    }
}
