<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\space\tests\codeception\functional;

use an602\modules\space\models\Space;
use FunctionalTester;

class DeleteSpaceCest
{
    public function testSpaceDeleteAccess(FunctionalTester $I)
    {
        $I->assertSpaceAccessFalse(Space::USERGROUP_MEMBER, '/space/manage/default/delete');
        $I->assertSpaceAccessFalse(Space::USERGROUP_USER, '/space/manage/default/delete');
        $I->assertSpaceAccessFalse(Space::USERGROUP_MODERATOR, '/space/manage/default/delete');
        $I->assertSpaceAccessFalse(Space::USERGROUP_ADMIN, '/space/manage/default/delete');
        $I->assertSpaceAccessTrue(Space::USERGROUP_OWNER, '/space/manage/default/delete');
        $I->assertSpaceAccessStatus(Space::USERGROUP_OWNER, 302, '/space/manage/default/delete', [], ['DeleteForm[confirmSpaceName]' => 'Space 2']);
        $I->assertSpaceAccessFalse(Space::USERGROUP_OWNER, '/space/space');
    }

    public function testSystemAdminDeletion(FunctionalTester $I)
    {
        $I->assertSpaceAccessTrue('root', '/space/manage/default/delete', [],  ['DeleteForm[confirmSpaceName]' => 'Space 2']);
    }
}
