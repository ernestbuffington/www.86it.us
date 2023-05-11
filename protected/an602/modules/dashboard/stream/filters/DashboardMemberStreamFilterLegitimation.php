<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\dashboard\stream\filters;

use Yii;
use an602\modules\content\models\Content;
use an602\modules\dashboard\Module;
use an602\modules\stream\models\filters\StreamQueryFilter;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;

/**
 * Stream filter handling dashboard content stream visibility for members of the network.
 *
 * Instead of the standard dashboard filter with complex SQL logic, this alternative filter uses the legitmation
 * IDs of the Live module.
 *
 * @see Module::memberFilterClass
 * @since 1.9
 */
class DashboardMemberStreamFilterLegitimation extends StreamQueryFilter
{
    /**
     * @var User
     */
    public $user;

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $ccIds = Yii::$app->getModule('live')->getLegitimateContentContainerIds($this->user, false);

        if ($this->isFollowAllProfilesActive()) {
            $x = User::find()->select('contentcontainer_id');
        } else {
            $x = $ccIds[Content::VISIBILITY_PUBLIC];
        }

        $this->query->andWhere([
            'OR',
            ['IN', 'content.contentcontainer_id', array_merge($ccIds[Content::VISIBILITY_PRIVATE], $ccIds[Content::VISIBILITY_OWNER])],
            ['AND',
                'content.visibility = ' . Content::VISIBILITY_PUBLIC,
                ['IN', 'content.contentcontainer_id', $x]
            ],
        ]);

        $this->excludeArchivedSpaceContent();
        $this->excludeNotShowInDashboardSpaces();
        $this->excludeNotEnabledUsers();
    }

    private function excludeArchivedSpaceContent()
    {
        $this->query->leftJoin(
            'space as spaceContainer',
            'spaceContainer.id = contentcontainer.pk AND contentcontainer.class = :spaceModel',
            [':spaceModel' => Space::class]
        );
        $this->query->andWhere(['OR', 'spaceContainer.id IS NULL', ['spaceContainer.status' => Space::STATUS_ENABLED]]);
    }

    private function excludeNotShowInDashboardSpaces()
    {
        $this->query->leftJoin(
            'space_membership',
            'space_membership.space_id = spaceContainer.id AND space_membership.user_id = :userId',
            [':userId' => $this->user->id]
        );
        $this->query->andWhere(['OR', 'space_membership.id IS NULL', ['space_membership.show_at_dashboard' => 1]]);
    }

    private function excludeNotEnabledUsers()
    {
        $this->query->leftJoin(
            'user AS userContainer',
            'userContainer.id = contentcontainer.pk AND contentcontainer.class = :userModel',
            [':userModel' => User::class]
        );
        $this->query->andWhere(['OR', 'userContainer.id IS NULL', ['userContainer.status' => User::STATUS_ENABLED]]);
    }

    /**
     * Checks for the `autoIncludeProfilePosts` module config.
     * @return bool
     */
    private function isFollowAllProfilesActive()
    {
        /* @var $dashboardModule Module */
        $dashboardModule = Yii::$app->getModule('dashboard');
        return $dashboardModule->autoIncludeProfilePosts === Module::STREAM_AUTO_INCLUDE_PROFILE_POSTS_ALWAYS
            || ($dashboardModule->autoIncludeProfilePosts === Module::STREAM_AUTO_INCLUDE_PROFILE_POSTS_ADMIN_ONLY && $this->user->isSystemAdmin());
    }
}
