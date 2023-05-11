<?php

namespace tests\codeception\unit\modules\live;

use an602\modules\content\models\Content;
use an602\modules\friendship\models\Friendship;
use an602\modules\live\Module;
use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use an602\modules\user\models\Follow;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;
use Yii;

class LegitimationTest extends an602DbTestCase
{
    public function _before()
    {
        Follow::deleteAll();
        Friendship::deleteAll();
        Membership::deleteAll();
        $this->enableFriendships(true);
        parent::_before();
    }

    public function testOwnProfileOwner()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('live');
        $user = User::findOne(['id' => 1]);
        $legitimations = $module->getLegitimateContentContainerIds($user, false);

        static::assertCount(1, $legitimations[Content::VISIBILITY_OWNER]);
        static::assertCount(0, $legitimations[Content::VISIBILITY_PRIVATE]);
        static::assertCount(0, $legitimations[Content::VISIBILITY_PUBLIC]);
        static::assertEquals($user->contentcontainer_id, $legitimations[Content::VISIBILITY_OWNER][0]);
    }

    public function testSpaceMemberCanSeePrivateContent()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('live');
        $user = User::findOne(['id' => 1]);
        $space1 = Space::findOne(['id' => 1]);
        $space1->addMember($user->id);
        $legitimations = $module->getLegitimateContentContainerIds($user, false);

        static::assertCount(1, $legitimations[Content::VISIBILITY_OWNER]);
        static::assertCount(0, $legitimations[Content::VISIBILITY_PUBLIC]);
        static::assertCount(1, $legitimations[Content::VISIBILITY_PRIVATE]);
        static::assertEquals($space1->contentcontainer_id, $legitimations[Content::VISIBILITY_PRIVATE][0]);
        static::assertEquals($user->contentcontainer_id, $legitimations[Content::VISIBILITY_OWNER][0]);
    }

    public function testFriendUserCanSeePrivateContent()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('live');
        $user1 = User::findOne(['id' => 1]);
        $user2 = User::findOne(['id' => 2]);

        static::assertTrue(Friendship::add($user1, $user2));
        static::assertTrue(Friendship::add($user2, $user1));

        $legitimations = $module->getLegitimateContentContainerIds($user1, false);

        static::assertCount(1, $legitimations[Content::VISIBILITY_OWNER]);
        static::assertCount(1, $legitimations[Content::VISIBILITY_PUBLIC]);
        static::assertCount(1, $legitimations[Content::VISIBILITY_PRIVATE]);
        static::assertEquals($user2->contentcontainer_id, $legitimations[Content::VISIBILITY_PRIVATE][0]);
        static::assertEquals($user1->contentcontainer_id, $legitimations[Content::VISIBILITY_OWNER][0]);
    }

    public function testFollowingUserCanSeePublicProfileContent()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('live');
        $user1 = User::findOne(['id' => 1]);
        $user2 = User::findOne(['id' => 2]);

        $user2->follow($user1);

        $legitimations = $module->getLegitimateContentContainerIds($user1, false);

        static::assertCount(1, $legitimations[Content::VISIBILITY_OWNER]);
        static::assertCount(0, $legitimations[Content::VISIBILITY_PRIVATE]);
        static::assertCount(1, $legitimations[Content::VISIBILITY_PUBLIC]);
        static::assertEquals($user2->contentcontainer_id, $legitimations[Content::VISIBILITY_PUBLIC][0]);
        static::assertEquals($user1->contentcontainer_id, $legitimations[Content::VISIBILITY_OWNER][0]);
    }

    public function testFollowingUserCanSeePublicSpaceContent()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('live');
        $user1 = User::findOne(['id' => 1]);
        $space1 = Space::findOne(['id' => 1]);

        $space1->follow($user1);

        $legitimations = $module->getLegitimateContentContainerIds($user1, false);

        static::assertCount(1, $legitimations[Content::VISIBILITY_OWNER]);
        static::assertCount(0, $legitimations[Content::VISIBILITY_PRIVATE]);
        static::assertCount(1, $legitimations[Content::VISIBILITY_PUBLIC]);
        static::assertEquals($space1->contentcontainer_id, $legitimations[Content::VISIBILITY_PUBLIC][0]);
        static::assertEquals($user1->contentcontainer_id, $legitimations[Content::VISIBILITY_OWNER][0]);
    }

}
