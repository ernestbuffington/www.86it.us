<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\components;

use an602\modules\user\models\Group;

/**
 * BaseAdminPermission is a fixed allowed permission for the admin group
 * 
 * @author buddha
 * @since 1.2
 */
class BaseAdminPermission extends \an602\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    protected $moduleId = 'admin';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_DENY;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->fixedGroups[] = Group::getAdminGroupId();

        parent::init();
    }

    /**
     * {@inheritdoc}
     * 
     * Note: that this function always returns state self::STATE_ALLOW for the administration
     * group, this behaviour can't be overwritten by means of the configuration.
     * 
     * Thi
     * @param type $groupId
     * @return type
     */
    public function getDefaultState($groupId)
    {
        if ($groupId == Group::getAdminGroupId()) {
            return self::STATE_ALLOW;
        }

        return parent::getDefaultState($groupId);
    }

}
