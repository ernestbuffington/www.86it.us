<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\tests\codeception\unit;

use an602\libs\BasePermission;
use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageModules;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageSpaces;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\admin\permissions\SeeAdminInformation;
use an602\modules\user\components\PermissionManager;

class PermissionManagerMock extends PermissionManager
{
    public $permissions = [
        2 => [
            ManageUsers::class,
            ManageGroups::class
        ],
        3 => [
            ManageUsers::class,
            ManageGroups::class,
            ManageModules::class,
            ManageSettings::class,
            ManageSpaces::class,
            SeeAdminInformation::class
        ]
    ];

    protected function verify(BasePermission $permission)
    {
        $subject = $this->getSubject();
        if ($subject) {
            $permissions = $this->permissions[$subject->id];
            return in_array(get_class($permission), $permissions);
        }
        return false;
    }
}
