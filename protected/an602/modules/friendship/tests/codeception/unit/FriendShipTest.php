<?php

namespace tests\codeception\unit\modules\friendship;

use Yii;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\friendship\models\Friendship;
use an602\modules\user\models\User;

class FriendshipTest extends an602DbTestCase
{

    use Specify;

    /**
     * Create a Mock Content class and assign a notify user save it and check if an email was sent and test wallout.
     */
    public function testAcceptFriendShip()
    {
        Yii::$app->getModule('friendship')->settings->set('enable', 1);

        $this->becomeUser('User2');
        $friendUser = User::findOne(['id' => 2]);

        $this->assertEquals(Friendship::getStateForUser($friendUser, Yii::$app->user->getIdentity()), Friendship::STATE_NONE, 'Check Status before sent');

        // Request Friendship
        $this->assertTrue(Friendship::add(Yii::$app->user->getIdentity(), $friendUser));
        $this->assertMailSent(1, 'Friendship request mail sent.');

        $fiendship = Friendship::findOne(['user_id' => Yii::$app->user->id, 'friend_user_id' => 2]);
        $this->assertNotNull($fiendship, 'Friendship model persisted.');
        $this->assertEquals(Friendship::getStateForUser(Yii::$app->user->getIdentity(), $friendUser), Friendship::STATE_REQUEST_SENT, 'Check Sent Status');
        $this->assertEquals(Friendship::getStateForUser($friendUser, Yii::$app->user->getIdentity()), Friendship::STATE_REQUEST_RECEIVED, 'Check Received Status');

        // Accept friendship
        $this->assertTrue(Friendship::add($friendUser, Yii::$app->user->getIdentity()));
        $this->assertEquals(Friendship::getStateForUser($friendUser, Yii::$app->user->getIdentity()), Friendship::STATE_FRIENDS, 'Check Friend Status');
        $this->assertMailSent(2, 'Friendship acknowledged mail sent.');
    }

    public function testDeclineFriendShip()
    {
        Yii::$app->getModule('friendship')->settings->set('enable', 1);

        $this->becomeUser('User2');
        $friendUser = User::findOne(['id' => 2]);

        $this->assertEquals(Friendship::getStateForUser($friendUser, Yii::$app->user->getIdentity()), Friendship::STATE_NONE, 'Check Status before sent');

        // Request Friendship
        $this->assertTrue(Friendship::add(Yii::$app->user->getIdentity(), $friendUser));
        $this->assertMailSent(1, 'Friendship request mail sent.');

        $fiendship = Friendship::findOne(['user_id' => Yii::$app->user->id, 'friend_user_id' => 2]);
        $this->assertNotNull($fiendship, 'Friendship model persisted.');
        $this->assertEquals(Friendship::getStateForUser(Yii::$app->user->getIdentity(), $friendUser), Friendship::STATE_REQUEST_SENT, 'Check Sent Status');
        $this->assertEquals(Friendship::getStateForUser($friendUser, Yii::$app->user->getIdentity()), Friendship::STATE_REQUEST_RECEIVED, 'Check Received Status');

        // Cancel request
        Friendship::cancel($friendUser, Yii::$app->user->getIdentity());
        $this->assertEquals(Friendship::getStateForUser($friendUser, Yii::$app->user->getIdentity()), Friendship::STATE_NONE, 'Check Friend Status');
        $this->assertMailSent(2, 'Friendship acknowledged mail sent.');
    }
}
