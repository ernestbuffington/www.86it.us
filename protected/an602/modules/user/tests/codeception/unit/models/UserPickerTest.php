<?php

namespace tests\codeception\unit\models;

use an602\modules\user\models\Profile;
use an602\modules\user\models\ProfileField;
use an602\modules\user\models\ProfileFieldCategory;
use an602\modules\user\models\User;
use an602\modules\user\models\UserFilter;
use an602\modules\user\models\UserPicker;
use tests\codeception\_support\an602DbTestCase;
use Yii;

class UserPickerTest extends an602DbTestCase
{
    public function testReturnFilteredUsers()
    {
        $users = UserPicker::filter(['maxResult' => 3, 'keyword' => 'Admin']);
        $this->assertEquals(2, count($users));
        $this->assertEquals('Admin Tester', $users[0]['text']);

        $users = UserPicker::filter(['maxResult' => 3, 'keyword' => 'Admin', 'fillUser' => true]);
        $this->assertEquals(2, count($users));
    }

}
