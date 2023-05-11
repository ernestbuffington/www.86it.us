<?php

namespace tests\codeception\unit\models;

use an602\modules\user\models\User;
use an602\modules\user\Module;
use an602\modules\user\permissions\PeopleAccess;
use an602\modules\user\permissions\ViewAboutPage;
use tests\codeception\_support\an602DbTestCase;

class UserModuleTest extends an602DbTestCase
{
    public function testModuleMethods()
    {
        $module = new Module('user');

        $this->assertEquals([new ViewAboutPage()], $module->getPermissions(new User()));
        $this->assertEquals([new PeopleAccess()], $module->getPermissions());

        $this->assertEquals('User', $module->getName());

        $this->assertEquals([
            'an602\modules\user\notifications\Followed',
            'an602\modules\user\notifications\Mentioned'
        ], $module->getNotifications());

        $this->assertEquals([
            '/^.{5,255}$/' => 'Password needs to be at least 5 characters long.',
        ], $module->getPasswordStrength());

        $module->passwordStrength = [
            '/^$/' => 'test'
        ];

        $this->assertTrue($module->isCustomPasswordStrength());

        $this->assertEquals([
            '/^$/' => 'test'
        ], $module->getPasswordStrength());
    }
}
