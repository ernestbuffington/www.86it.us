<?php

namespace tests\codeception\unit\modules\space;

use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;
use Yii;

class MembershipTest extends an602DbTestCase
{
    public function testJoinPolicityApprovalApprove()
    {
        $this->becomeUser('User1');

        $user1 = Yii::$app->user->getIdentity();

        // Request Membership for Space 1 (approval join policity)
        $space = Space::findOne(['id' => 1]);
        $space->requestMembership(Yii::$app->user->id, 'Let me in!');

        // Check approval mails are send and notification
        $this->assertSentEmail(1); // Approval notification admin mail
        $this->assertHasNotification(\an602\modules\space\notifications\ApprovalRequest::class, $space,
            Yii::$app->user->id, 'Approval Request Notification');

        $membership = Membership::findOne(['space_id' => 1, 'user_id' => Yii::$app->user->id]);
        $this->assertNotNull($membership);
        $this->assertEquals($membership->status, Membership::STATUS_APPLICANT);

        $this->becomeUser('Admin');

        $space->addMember(2);
        $this->assertSentEmail(2); //Approval notification admin mail
        $this->assertHasNotification(\an602\modules\space\notifications\ApprovalRequestAccepted::class, $space, 1,
            'Approval Accepted Notification');

        $memberships = Membership::findByUser($user1)->all();
        $this->assertNotEmpty($memberships, 'get all memberships of user query.');
        $match = null;

        foreach ($memberships as $membership) {
            if ($membership->user_id == $user1->id) {
                $match = $membership;
            }
        }

        $this->assertNotNull($match);
    }

    public function testJoinPolicityApprovalDecline()
    {
        $this->becomeUser('User1');

        // Space 1 is approval space
        $space = Space::findOne(['id' => 1]);
        $space->requestMembership(Yii::$app->user->id, 'Let me in!');

        $this->assertSentEmail(1); // Approval notification admin mail
        $this->assertHasNotification(\an602\modules\space\notifications\ApprovalRequest::class, $space,
            Yii::$app->user->id, 'Approval Request Notification');

        $membership = Membership::findOne(['space_id' => 1, 'user_id' => Yii::$app->user->id]);
        $this->assertNotNull($membership);
        $this->assertEquals($membership->status, Membership::STATUS_APPLICANT);

        $this->becomeUser('Admin');

        $space->removeMember(2);
        $this->assertSentEmail(2); // Rejection notification admin mail
        $this->assertHasNotification(\an602\modules\space\notifications\ApprovalRequestDeclined::class, $space, 1,
            'Approval Accepted Notification');
    }

    public function testChangeRoleMembership()
    {
        $membership = Membership::findOne(['space_id' => 3, 'user_id' => 2]);

        \an602\modules\space\notifications\ChangedRolesMembership::instance()
            ->about($membership)
            ->from(User::findOne(['id' => 1]))
            ->send($membership->user);

        $this->assertSentEmail(1);
    }
}
