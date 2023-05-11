<?php

namespace tests\codeception\unit\modules\admin;

use an602\libs\BasePermission;
use an602\modules\content\components\ContentContainerDefaultPermissionManager;
use an602\modules\like\permissions\CanLike;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;

class DefaultPermissionsTest extends an602DbTestCase
{

    public function testSetDefaultSpacePermission()
    {
        $this->becomeUser('Admin');

        $space = new Space();
        $space->name = 'Test Space';
        $space->save();
        $this->assertFalse($space->isNewRecord);

        $testGroupId = $space::USERGROUP_USER;
        $testState = BasePermission::STATE_DENY;
        $testPermission = new CanLike;

        $defaultPermissionManager = new ContentContainerDefaultPermissionManager([
            'contentContainerClass' => get_class($space),
        ]);
        $defaultPermission = $defaultPermissionManager->getById(get_class($testPermission), $testPermission->getModuleId());
        $this->assertNotNull($defaultPermission);
        $defaultPermissionManager->setGroupState($testGroupId, $defaultPermission, $testState);

        $spacePermissionManager = $space->getPermissionManager();
        $spacePermission = $spacePermissionManager->getById(get_class($testPermission), $testPermission->getModuleId());
        $this->assertNotNull($spacePermission);

        $this->assertEquals($spacePermissionManager->getSingleGroupDefaultState($testGroupId, $spacePermission), $testState);
    }

    public function testSetDefaultUserPermission()
    {
        $this->becomeUser('Admin');

        $user = new User();
        $user->username = 'test_user';
        $user->email = 'test@user.mail';
        $user->save();
        $this->assertFalse($user->isNewRecord);

        $testGroupId = $user::USERGROUP_USER;
        $testState = BasePermission::STATE_ALLOW;
        $testPermission = new CanLike;

        $defaultPermissionManager = new ContentContainerDefaultPermissionManager([
            'contentContainerClass' => get_class($user),
        ]);
        $defaultPermission = $defaultPermissionManager->getById(get_class($testPermission), $testPermission->getModuleId());
        $this->assertNotNull($defaultPermission);
        $defaultPermissionManager->setGroupState($testGroupId, $defaultPermission, $testState);

        $userPermissionManager = $user->getPermissionManager();
        $userPermission = $userPermissionManager->getById(get_class($testPermission), $testPermission->getModuleId());
        $this->assertNotNull($userPermission);

        $this->assertEquals($userPermissionManager->getSingleGroupDefaultState($testGroupId, $userPermission), $testState);
    }
}
