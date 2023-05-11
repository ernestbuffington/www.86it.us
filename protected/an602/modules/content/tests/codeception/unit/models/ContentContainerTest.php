<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content;

use an602\modules\content\models\Content;
use an602\modules\content\models\ContentContainer;
use an602\modules\user\models\User;
use modules\content\tests\codeception\_support\ContentModelTest;

class ContentContainerTest extends ContentModelTest
{

    public function testUniqueGuid()
    {
        $user = User::findOne(['id' => 1]);
        $contentContainer = new ContentContainer(['guid' => $user->guid]);
        $contentContainer->setPolymorphicRelation($user);

        $this->assertFalse($contentContainer->save());
        $this->assertNotEmpty($contentContainer->getErrors('guid'));
    }

    public function testUniqueModel()
    {
        $user = User::findOne(['id' => 1]);
        $contentContainer = new ContentContainer(['guid' => 'xyz']);
        $contentContainer->setPolymorphicRelation($user);


        $this->assertFalse($contentContainer->save());
        $this->assertNotEmpty($contentContainer->getErrors('pk'));
    }

    public function testGuidRequired()
    {
        $user = User::findOne(['id' => 1]);
        $contentContainer = new ContentContainer();
        $contentContainer->setPolymorphicRelation($user);

        $this->assertFalse($contentContainer->save());
        $this->assertNotEmpty($contentContainer->getErrors('guid'));
    }

    public function testModelRequired()
    {
        $contentContainer = new ContentContainer();

        $this->assertFalse($contentContainer->save());
        $this->assertNotEmpty($contentContainer->getErrors('class'));
    }

    public function testInvalidModel()
    {
        $contentContainer = new ContentContainer();
        $contentContainer->setPolymorphicRelation(Content::findOne(['id' => 1]));

        $this->assertFalse($contentContainer->save());
        $this->assertNotEmpty($contentContainer->getErrors('class'));
    }

    public function testFindByGuid()
    {
        $user = User::findOne(['id' => 1]);
        $userRecord = ContentContainer::findRecord($user->guid);

        $this->assertInstanceOf(User::class, $userRecord);
        $this->assertEquals($user->id, $userRecord->id);
        $this->assertEquals($user->contentcontainer_id, $userRecord->contentcontainer_id);
    }

    public function testFindByInvalidGuid()
    {
        $this->assertNull(ContentContainer::findRecord('xxx'));
    }
}
