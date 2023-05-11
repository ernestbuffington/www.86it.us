<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content;

use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;

use an602\modules\space\models\Space;
use Yii;

class ContentContainerActiveRecordTest extends an602DbTestCase
{

    public function testUserIsNotASpace()
    {
        $user = User::findOne(['id' => 1]);
        $space = Space::findOne(['id' => 2]);

        $this->assertFalse($user->is($space));
    }

    public function testSpaceIsSameSpace()
    {
        $space = Space::findOne(['id' => 1]);
        $space1 = Space::findOne(['id' => 1]);

        $this->assertTrue($space->is($space1));
    }

    public function testUserIsNotAnotherUser()
    {
        $user = User::findOne(['id' => 1]);
        $user2 = User::findOne(['id' => 2]);

        $this->assertFalse($user->is($user2));
    }

    public function testUserIsSameUser()
    {
        $user = User::findOne(['id' => 1]);
        $user1 = User::findOne(['id' => 1]);

        $this->assertTrue($user->is($user1));
    }

    public function testGuestISNotUser()
    {
        $user = User::findOne(['id' => 1]);

        $this->assertFalse($user->is(Yii::$app->user->getIdentity()));
    }

    public function testNullISNotUser()
    {
        $space = Space::findOne(['id' => 1]);

        $this->assertFalse($space->is(null));
    }
}
