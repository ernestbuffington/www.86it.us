<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\permissions;

use an602\modules\space\models\Space;
use an602\modules\user\models\User;

/**
 * CreateComment Permission
 */
class CreateComment extends \an602\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_ADMIN,
        Space::USERGROUP_MODERATOR,
        Space::USERGROUP_MEMBER,
        Space::USERGROUP_USER,
        User::USERGROUP_USER,
        User::USERGROUP_SELF,
        User::USERGROUP_FRIEND,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Space::USERGROUP_GUEST,
        User::USERGROUP_GUEST,
    ];

    /**
     * @inheritdoc
     */
    protected $title = 'Create comment';

    /**
     * @inheritdoc
     */
    protected $description = 'Allows the user to add comments';

    /**
     * @inheritdoc
     */
    protected $moduleId = 'comment';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('CommentModule.permissions', 'Create comment');
        $this->description = \Yii::t('CommentModule.permissions', 'Allows the user to add comments');
    }

}
