<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\permissions;

use an602\modules\admin\components\BaseAdminPermission;

/**
 * ManageUsersAdvanced Permission allows access to users/userstab section within the admin area.
 *
 * @since 1.2
 */
class ManageGroups extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_manage_groups';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Manage Groups');
        $this->description = \Yii::t('AdminModule.permissions', 'Can manage users and groups');
    }

}
