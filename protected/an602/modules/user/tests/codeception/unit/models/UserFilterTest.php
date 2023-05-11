<?php

namespace tests\codeception\unit\models;

use an602\modules\user\models\Profile;
use an602\modules\user\models\ProfileField;
use an602\modules\user\models\ProfileFieldCategory;
use an602\modules\user\models\User;
use an602\modules\user\models\UserFilter;
use tests\codeception\_support\an602DbTestCase;
use Yii;

class UserFilterTest extends an602DbTestCase
{
    public function testReturnInstanceForUser()
    {
        $user = UserFilter::findOne(['username' => 'Admin']);
        $user2 = UserFilter::findOne(['username' => 'User1']);
        Yii::$app->user->setIdentity($user);
        $this->assertEquals($user, UserFilter::forUser());
        $this->assertEquals($user2, UserFilter::forUser($user2));
    }

    public function testFilterByPermission()
    {
        $users = User::find()->all();

        $this->assertTrue(is_array(UserFilter::filterByPermission($users, null)));
        $this->assertEquals(count($users), count(UserFilter::filterByPermission($users, null)));
    }

    public function testReturnFilteredUsers()
    {
        $users = UserFilter::filter(User::find(), 'Admin', 5);

        $this->assertEquals(2, count($users));
        $this->assertEquals('Admin', $users[0]->username);
    }

}
