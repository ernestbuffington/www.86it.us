<?php

namespace tests\codeception\unit\modules\space;

use Yii;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\space\models\Space;

class InviteTest extends an602DbTestCase
{

    use Specify;

    public function testInviteAccept()
    {
        $this->becomeUser('Admin');

        // Space 1 is approval space
        $space = Space::findOne(['id' => 1]);
        $space->inviteMember(2, Yii::$app->user->id);

        $this->assertMailSent(1, 'Approval notification admin mail');
        $this->assertHasNotification(\an602\modules\space\notifications\Invite::class, $space, Yii::$app->user->id, 'Invite Request Notification');

        $membership = \an602\modules\space\models\Membership::findOne(['space_id' => 1, 'user_id' => 2]);
        $this->assertNotNull($membership);
        $this->assertEquals($membership->status, \an602\modules\space\models\Membership::STATUS_INVITED);

        $this->becomeUser('User1');

        $space->addMember(2);
        $this->assertMailSent(2, 'Approval notification admin mail');
        $this->assertHasNotification(\an602\modules\space\notifications\InviteAccepted::class, $space, 2, 'Approval Accepted Invite Notificatoin');
    }

    public function testInviteDecline()
    {
        $this->becomeUser('Admin');

        // Space 1 is approval space
        $space = Space::findOne(['id' => 1]);
        $space->inviteMember(2, Yii::$app->user->id);

        $this->assertMailSent(1, 'Approval notification admin mail');
        $this->assertHasNotification(\an602\modules\space\notifications\Invite::class, $space, Yii::$app->user->id, 'Invite Request Notification');

        $membership = \an602\modules\space\models\Membership::findOne(['space_id' => 1, 'user_id' => 2]);
        $this->assertNotNull($membership);
        $this->assertEquals($membership->status, \an602\modules\space\models\Membership::STATUS_INVITED);

        $this->becomeUser('User1');

        $space->removeMember();
        $this->assertMailSent(2, 'Approval notification admin mail');
        $this->assertHasNotification(\an602\modules\space\notifications\InviteDeclined::class, $space, 2, 'Declined Invite Notificatoin');
    }

}
