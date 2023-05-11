<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace tests\codeception\unit;

use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageSpaces;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\admin\permissions\SeeAdminInformation;
use an602\modules\user\tests\codeception\unit\PermissionManagerMock;
use tests\codeception\_support\an602DbTestCase;

class PermissionManagerTest extends an602DbTestCase
{

    /**
     *  Tests user approval for 1 user without group assignment and one user with group assignment.
     */
    public function testPermissionUser1()
    {
        $this->becomeUser('User1');
        $permissionManager = new PermissionManagerMock();

        $tests = [
            [true, new ManageUsers],
            [true, ManageUsers::class],
            [false, new ManageSettings],
            [false, ManageSettings::class],
            [true, [new ManageSettings, new ManageUsers]],
            [false, [new ManageSettings, new ManageUsers], ['all' => true]],
            [true, [new ManageUsers, new ManageGroups], ['all' => true]],
            [false, [ManageSettings::class, ManageSpaces::class, SeeAdminInformation::class]],
            [false, [ManageSettings::class, ManageSpaces::class, SeeAdminInformation::class], ['all' => true]],
            [true, [ManageSettings::class, ManageUsers::class]],
            [false, [ManageSettings::class, ManageUsers::class], ['all' => true]],
            [true, [ManageUsers::class, ManageGroups::class], ['all' => true]],
        ];

        foreach ($tests as $index => $test) {
            if (isset($test[2])) {
                $this->assertEquals($test[0], $permissionManager->can($test[1], $test[2]));
            } else {
                $this->assertEquals($test[0], $permissionManager->can($test[1]));
            }
        }
    }
}
