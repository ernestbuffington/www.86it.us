<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace tests\codeception\unit\models;


use tests\codeception\_support\an602DbTestCase;
use an602\modules\user\models\User;

class UsernameTest extends an602DbTestCase
{

    public function testUserNameValidation()
    {
        $user = User::findOne(['id' => 1]);
        $user->username = 'valid';
        $this->assertTrue($user->validate('username'));
        $user->username = "test\x00Char";
        $this->assertFalse($user->validate('username'));
        $user->username = 'test/slash';
        $this->assertFalse($user->validate('username'));
        $user->username = '123890AßäöüÄÖÜĆ_-@#$%^&*()[]{}+=<>:;,.?!|~"\'\\';
        $this->assertFalse($user->validate('username'));
        $user->username = 'user@example.com';
        $this->assertTrue($user->validate('username'));
        $user->username = 'user-name';
        $this->assertTrue($user->validate('username'));
        $user->username = 'user_name';
        $this->assertTrue($user->validate('username'));
        $user->username = 'user.name';
        $this->assertTrue($user->validate('username'));
    }

}
