<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\components;

use an602\events\ActiveQueryEvent;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\content\components\AbstractActiveQueryContentContainer;
use an602\modules\user\models\fieldtype\BaseTypeVirtual;
use an602\modules\user\models\Group;
use an602\modules\user\models\GroupUser;
use an602\modules\user\models\ProfileField;
use an602\modules\user\models\User;
use an602\modules\user\models\User as UserModel;
use an602\modules\user\Module;
use Yii;
use yii\db\ActiveQuery;

/**
 * ActiveQueryUser is used to query User records.
 *
 * @author luke
 */
class ActiveQueryUser extends AbstractActiveQueryContentContainer
{
    /**
     * @event Event an event that is triggered when only visible users are requested via [[visible()]].
     */
    const EVENT_CHECK_VISIBILITY = 'checkVisibility';

    /**
     * @event Event an event that is triggered when only active users are requested via [[active()]].
     */
    const EVENT_CHECK_ACTIVE = 'checkActive';

    /**
     * Limit to active users
     *
     * @return ActiveQueryUser the query
     */
    public function active()
    {
        $this->trigger(self::EVENT_CHECK_ACTIVE, new ActiveQueryEvent(['query' => $this]));
        return $this->andWhere(['user.status' => UserModel::STATUS_ENABLED]);
    }

    /**
     * Returns only users that should appear in user lists or in the search results.
     * Also only active (enabled) users are returned.
     *
     * @since 1.2.3
     * @inheritdoc
     * @return self
     */
    public function visible(?User $user = null): ActiveQuery
    {
        $this->trigger(self::EVENT_CHECK_VISIBILITY, new ActiveQueryEvent(['query' => $this]));

        $this->active();

        if ($user === null && !Yii::$app->user->isGuest) {
            try {
                $user = Yii::$app->user->getIdentity();
            } catch (\Throwable $e) {
                Yii::error($e, 'user');
            }
        }

        $allowedVisibilities = [UserModel::VISIBILITY_ALL];
        if ($user === null) {
            // Guest can view only public users
            return $this->andWhere(['IN', 'user.visibility', $allowedVisibilities]);
        }

        if ((new PermissionManager(['subject' => $user]))->can(ManageUsers::class)) {
            // Admin/manager can view users with any visibility status
            return $this;
        }

        $allowedVisibilities[] = UserModel::VISIBILITY_REGISTERED_ONLY;

        return $this->andWhere(['OR',
            ['user.id' => $user->id], // User also can view own profile
            ['IN', 'user.visibility', $allowedVisibilities]
        ]);
    }


    /**
     * Adds default user order (e.g. by lastname)
     *
     * @return ActiveQueryUser the query
     */
    public function defaultOrder()
    {
        $this->joinWith('profile');
        $this->addOrderBy(['profile.lastname' => SORT_ASC]);

        return $this;
    }


    /**
     * @inheritdoc
     */
    protected function getSearchableFields(): array
    {
        $this->joinWith('profile')->joinWith('contentContainerRecord');

        $fields = ['user.username', 'contentcontainer.tags_cached'];

        /** @var Module $module */
        $module = Yii::$app->getModule('user');

        if ($module->includeEmailInSearch) {
            $fields[] = 'user.email';
        }

        foreach (ProfileField::findAll(['searchable' => 1]) as $profileField) {
            if (!($profileField->getFieldType() instanceof BaseTypeVirtual)) {
                $fields[] = 'profile.' . $profileField->internal_name;
            }
        }

        return $fields;
    }

    /**
     * Limits the query to a specified user group
     *
     * @param Group $group
     * @return ActiveQueryUser the query
     */
    public function isGroupMember(Group $group)
    {
        $this->leftJoin('group_user', 'user.id=group_user.user_id');
        $this->andWhere(['group_user.group_id' => $group->id]);

        return $this;
    }

    /**
     * Returns only users which are administrable by the given user.
     *
     * @param UserModel $user
     * @return ActiveQueryUser the query
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function administrableBy(UserModel $user)
    {

        if (!(new PermissionManager(['subject' => $user]))->can([ManageUsers::class])) {
            $this->joinWith('groups');

            $groupIds = [];
            foreach (GroupUser::find()->where(['user_id' => $user->id, 'is_group_manager' => 1])->all() as $gu) {
                $groupIds[] = $gu->group_id;
            }

            $this->andWhere(['IN', 'group.id', $groupIds]);
        }

        return $this;
    }

    /**
     * Exclude blocked users for the given $user or for the current User
     *
     * @param UserModel $user
     * @return ActiveQueryUser the query
     */
    public function filterBlockedUsers(?UserModel $user = null): ActiveQueryUser
    {
        if ($user === null && !Yii::$app->user->isGuest) {
            $user = Yii::$app->user->getIdentity();
        }

        if (!($user instanceof UserModel)) {
            return $this;
        }

        /* @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        if (!$userModule->allowBlockUsers()) {
            return $this;
        }

        $this->leftJoin('contentcontainer_blocked_users', 'contentcontainer_blocked_users.contentcontainer_id=user.contentcontainer_id AND contentcontainer_blocked_users.user_id=:blockedUserId', [':blockedUserId' => $user->id]);
        $this->andWhere('contentcontainer_blocked_users.user_id IS NULL');

        return $this;
    }

    /**
     * Filter users which are available for the given $user or for the current User
     *
     * @since 1.13
     * @param UserModel|null $user
     * @return ActiveQueryUser
     */
    public function available(?UserModel $user = null): ActiveQueryUser
    {
        return $this->visible($user)->filterBlockedUsers($user);
    }

}
