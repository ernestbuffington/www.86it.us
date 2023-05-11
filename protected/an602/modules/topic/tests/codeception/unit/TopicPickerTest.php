<?php

namespace tests\codeception\unit;

use an602\modules\post\models\Post;
use an602\modules\space\models\Space;
use an602\modules\topic\models\Topic;
use an602\modules\topic\widgets\TopicPicker;
use tests\codeception\_support\an602DbTestCase;

class TopicPickerTest extends an602DbTestCase
{
    /**
     * Make sure users with create topic permission sees topic picker
     */
    public function testUserWithCreateTopicPermissionSeesTopicPickerWithSpaceTopics()
    {
        // User2 is moderator in Space3
        $space = Space::findOne(3);
        $this->becomeUser('User2');

        $topic = new Topic($space);
        $topic->name = 'TestTopic';
        $this->assertTrue($topic->save());

        $this->assertTrue(TopicPicker::showTopicPicker($space));
    }

    /**
     * Make sure users with create topic permission sees topic picker even if there are no topics available
     */
    public function testUserWithCreateTopicPermissionSeesTopicPickerWithoutSpaceTopics()
    {
        // User2 is moderator in Space3
        $space = Space::findOne(3);
        $this->becomeUser('User2');
        $this->assertTrue(TopicPicker::showTopicPicker($space));
    }

    /**
     * Make sure users without create topic permission sees topic picker if topics are available
     */
    public function testUserWithoutCreateTopicPermissionSeesTopicPickerWithSpaceTopics()
    {
        // User1 is member in Space3
        $space = Space::findOne(3);
        $this->becomeUser('User1');

        $topic = new Topic($space);
        $topic->name = 'TestTopic';
        $this->assertTrue($topic->save());

        $this->assertTrue(TopicPicker::showTopicPicker($space));
    }

    /**
     * Make sure users without create topic permission does not sees topic picker if there are no topics available
     */
    public function testUserWithoutCreateTopicPermissionDoesNotSeesTopicPickerWithoutSpaceTopics()
    {
        // User1 is member in Space3
        $space = Space::findOne(3);
        $this->becomeUser('User1');
        $this->assertFalse(TopicPicker::showTopicPicker($space));
    }


}
