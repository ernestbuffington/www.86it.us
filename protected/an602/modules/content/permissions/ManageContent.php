<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\permissions;

use an602\modules\user\models\User;
use an602\modules\space\models\Space;
use Yii;

/**
 * Manage content permission for a content container
 * 
 * @since 1.1
 * @author Luke
 */
class ManageContent extends \an602\libs\BasePermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'content';

    /**
     * @inheritdoc
     */
    protected $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_ADMIN,
        Space::USERGROUP_MODERATOR,
        User::USERGROUP_SELF
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Space::USERGROUP_GUEST,
        Space::USERGROUP_MEMBER,
        Space::USERGROUP_USER,
        User::USERGROUP_SELF,
        User::USERGROUP_FRIEND,
        User::USERGROUP_USER,
        User::USERGROUP_GUEST
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return  Yii::t('CommentModule.permissions', 'Manage content');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('CommentModule.permissions', 'Can manage (e.g. archive, stick, move or delete) arbitrary content');
    }
}
