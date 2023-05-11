<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\permissions;

use an602\libs\BasePermission;
use an602\modules\space\models\Space;
use Yii;

/**
 * Invite new users to space permission
 */
class InviteUsers extends BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_ADMIN,
        Space::USERGROUP_MODERATOR,
        Space::USERGROUP_MEMBER,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Space::USERGROUP_USER,
        Space::USERGROUP_GUEST,
    ];

    /**
     * @inheritdoc
     */
    protected $title = 'Invite users';

    /**
     * @inheritdoc
     */
    protected $description = 'Allows the user to invite new members to the space';

    /**
     * @inheritdoc
     */
    protected $moduleId = 'space';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = Yii::t('SpaceModule.permissions', 'Invite users');
        $this->description = Yii::t('SpaceModule.permissions', 'Allows the user to invite new members to the space');
    }

}
