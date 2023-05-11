<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\post\permissions;

use Yii;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;

/**
 * CreatePost Permission
 */
class CreatePost extends \an602\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_ADMIN,
        Space::USERGROUP_MODERATOR,
        Space::USERGROUP_MEMBER,
        User::USERGROUP_SELF,
        User::USERGROUP_FRIEND
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Space::USERGROUP_USER,
        Space::USERGROUP_GUEST,
        User::USERGROUP_SELF,
        User::USERGROUP_GUEST
    ];

    /**
     * @inheritdoc
     */
    protected $moduleId = 'post';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('PostModule.base', 'Create post');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        if ($this->contentContainer instanceof User) {
            return Yii::t('PostModule.base', 'Allow others to create new posts on your profile page');
        }
        return Yii::t('PostModule.base', 'Allows the user to create posts');
    }

}
