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
use an602\modules\content\models\ContentType;
use an602\modules\content\tests\codeception\unit\TestContent;
use an602\modules\post\models\Post;
use an602\modules\user\models\User;
use modules\content\tests\codeception\_support\ContentModelTest;

class ContentTypeTest extends ContentModelTest
{

    public function _before()
    {
        parent::_before();
        ContentType::flush();
        // Make sure there is no content
        Content::deleteAll();
        Post::deleteAll();
    }

    public function testContainerContentTypes()
    {
        $user = User::findOne(['id' => 1]);
        $this->assertEmpty(ContentType::getContentTypes($user));

        $testContent = new TestContent($user, ['message' => 'TestContent']);
        $this->assertTrue($testContent->save());

        ContentType::flush();
        $contentTypes = ContentType::getContentTypes($user);
        $this->assertCount(1, $contentTypes);
        $this->assertEquals(TestContent::class, $contentTypes[0]->typeClass);
        $this->assertEquals($testContent->getContentName(), $contentTypes[0]->getContentName());

        $testPost = new Post($user, ['message' => 'TestPost']);
        $this->assertTrue($testPost->save());

        ContentType::flush();
        $contentTypes = ContentType::getContentTypes($user);
        $this->assertCount(2, $contentTypes);
        $this->assertEquals(TestContent::class, $contentTypes[0]->typeClass);
        $this->assertEquals($testContent->getContentName(), $contentTypes[0]->getContentName());
        $this->assertEquals($testContent->getIcon(), $contentTypes[0]->getIcon());

        $this->assertEquals(Post::class, $contentTypes[1]->typeClass);
        $this->assertEquals($testPost->getContentName(), $contentTypes[1]->getContentName());
        $this->assertEquals($testPost->getIcon(), $contentTypes[1]->getIcon());

        $select = ContentType::getContentTypeSelection($user);
        $this->assertEquals(TestContent::class, array_keys($select)[0]);
        $this->assertEquals($testContent->getContentName(), $select[TestContent::class]);
        $this->assertEquals(Post::class, array_keys($select)[1]);
        $this->assertEquals($testPost->getContentName(), $select[Post::class]);
    }

    public function testGlobalContentTypes()
    {
        $this->assertEmpty(ContentType::getContentTypes());

        $testContent = new TestContent(User::findOne(['id' => 1]), ['message' => 'TestContent']);
        $this->assertTrue($testContent->save());

        ContentType::flush();
        $contentTypes = ContentType::getContentTypes();
        $this->assertCount(1, $contentTypes);
        $this->assertEquals(TestContent::class, $contentTypes[0]->typeClass);
        $this->assertEquals($testContent->getContentName(), $contentTypes[0]->getContentName());

        $testPost = new Post(User::findOne(['id' => 2]), ['message' => 'TestPost']);
        $this->assertTrue($testPost->save());

        ContentType::flush();
        $contentTypes = ContentType::getContentTypes();
        $this->assertCount(2, $contentTypes);
        $this->assertEquals(TestContent::class, $contentTypes[0]->typeClass);
        $this->assertEquals($testContent->getContentName(), $contentTypes[0]->getContentName());
        $this->assertEquals(Post::class, $contentTypes[1]->typeClass);
        $this->assertEquals($testPost->getContentName(), $contentTypes[1]->getContentName());

        $select = ContentType::getContentTypeSelection();
        $this->assertEquals(TestContent::class, array_keys($select)[0]);
        $this->assertEquals($testContent->getContentName(), $select[TestContent::class]);
        $this->assertEquals(Post::class, array_keys($select)[1]);
        $this->assertEquals($testPost->getContentName(), $select[Post::class]);
    }
}
