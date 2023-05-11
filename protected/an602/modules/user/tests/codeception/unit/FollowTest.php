<?php

namespace tests\codeception\unit;

use an602\modules\user\models\Follow;
use an602\modules\user\models\User;
use an602\modules\user\notifications\Followed;
use tests\codeception\_support\an602DbTestCase;
use Yii;

class FollowTest extends an602DbTestCase
{

    public function testFollowUser()
    {
        $this->becomeUser('User1');

        $user = User::findOne(['id' => 1]);
        $this->assertTrue($user->follow());

        $follow = Follow::findOne(['object_model' => User::class, 'object_id' => 1, 'user_id' => 2]);

        $this->assertNotNull($follow);
        $this->assertMailSent(1, 'User follow notification Mail.');
        $this->assertHasNotification(Followed::class, $follow, Yii::$app->user->id, 'Approval Request Notification');
    }
}
