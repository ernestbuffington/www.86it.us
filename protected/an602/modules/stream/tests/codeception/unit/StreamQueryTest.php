<?php

namespace tests\codeception\unit;

use an602\modules\content\models\Content;
use an602\modules\post\models\Post;
use an602\modules\space\models\Space;
use an602\modules\stream\actions\Stream;
use an602\modules\stream\models\StreamQuery;
use tests\codeception\_support\an602DbTestCase;
use yii\base\Exception;

class StreamQueryTest extends an602DbTestCase
{
    public $space;

    public function _before()
    {
        parent::_before();

        // Clear fixture content
        foreach(Content::find()->all() as $content) {
            $content->delete();
        }

        $this->space =  Space::findOne(['id' => 1]);
    }

    /**
     * @param $text
     * @param $creation
     * @param $update
     * @return Post
     * @throws Exception
     */
    protected function createPost($text, $streamSort = null )
    {
        $this->becomeUser('Admin');

        $post = new Post(['message' => $text]);
        $post->save();

        if($streamSort) {
            $post->content->updateAttributes(['stream_sort_date' => $streamSort]);
        }

        return $post;
    }

    /**
     * Tests Stream::SORT_CREATED_AT query order. The result should ignore the stream sort date.
     * @throws Exception
     */
    public function testCreatedAtOrder()
    {
        $this->createPost('Test1', '2020-02-20 10:00:00');
        $this->createPost('Test2', '2020-02-19 10:00:00');
        $this->createPost('Test3', '2020-02-16 10:00:00');
        $this->createPost('Test4', '2020-02-18 10:00:00');


        $result = (new StreamQuery())->sort(Stream::SORT_CREATED_AT)->all();
        $this->assertCount(4, $result);

        $this->assertEquals('Test4', $result[0]->getModel()->message);
        $this->assertEquals('Test3', $result[1]->getModel()->message);
        $this->assertEquals('Test2', $result[2]->getModel()->message);
        $this->assertEquals('Test1', $result[3]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_UPDATED_AT query order. The result should respect the stream sort date.
     * @throws Exception
     */
    public function testUpdatedAtOrder()
    {
        $this->createPost('Test1', '2020-02-20 10:00:00');
        $this->createPost('Test2', '2020-02-19 10:00:00');
        $this->createPost('Test4', '2020-02-18 10:00:00');
        $this->createPost('Test3', '2020-02-16 10:00:00');

        $result = (new StreamQuery())->sort(Stream::SORT_UPDATED_AT)->all();
        $this->assertCount(4, $result);

        $this->assertEquals('Test1', $result[0]->getModel()->message);
        $this->assertEquals('Test2', $result[1]->getModel()->message);
        $this->assertEquals('Test4', $result[2]->getModel()->message);
        $this->assertEquals('Test3', $result[3]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_UPDATED_AT in combination with from filter.
     * @throws Exception
     */
    public function testFromUpdatedAt()
    {
        $p1 = $this->createPost('Test1', '2020-02-20 10:00:00');
        $p2 = $this->createPost('Test2', '2020-02-19 10:00:00');
        $p4 = $this->createPost('Test4', '2020-02-18 10:00:00');
        $p3 = $this->createPost('Test3', '2020-02-16 10:00:00');

        $result = (new StreamQuery())->sort(Stream::SORT_UPDATED_AT)->from($p2->content->id)->all();
        $this->assertCount(2, $result);

        $this->assertEquals($p4->message, $result[0]->getModel()->message);
        $this->assertEquals($p3->message, $result[1]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_UPDATED_AT in combination with from filter while having entries with equal stream sort date.
     * This test should ensure that only content which were created before the given search content are included in
     * the result.
     * @throws Exception
     */
    public function testFromUpdatedAtWithEqualDate()
    {
        $p1 = $this->createPost('Test1', '2020-02-18 10:00:00');
        $p2 = $this->createPost('Test2', '2020-02-18 10:00:00');
        $p4 = $this->createPost('Test4', '2020-02-18 10:00:00');
        $p3 = $this->createPost('Test3', '2020-02-16 10:00:00');

        $result = (new StreamQuery())->sort(Stream::SORT_UPDATED_AT)->from($p2->content->id)->all();
        // Result should include p3 and p4 whereas p1,p2,p4 have the same sort date but p1 was created prior to p2
        $this->assertCount(2, $result);

        $this->assertEquals($p4->message, $result[0]->getModel()->message);
        $this->assertEquals($p3->message, $result[1]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_CREATED_AT in combination with from filter.
     * @throws Exception
     */
    public function testFromCreatedAt()
    {
        $p1 = $this->createPost('Test1', '2020-02-20 10:00:00');
        $p2 = $this->createPost('Test2', '2020-02-19 10:00:00');
        $p3 = $this->createPost('Test3', '2020-02-16 10:00:00');
        $p4 = $this->createPost('Test4', '2020-02-18 10:00:00');

        $result = (new StreamQuery())->from($p3->content->id)->sort(Stream::SORT_CREATED_AT)->all();
        $this->assertCount(2, $result);

        $this->assertEquals($p2->message, $result[0]->getModel()->message);
        $this->assertEquals($p1->message, $result[1]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_CREATED_AT in combination with to filter.
     * @throws Exception
     */
    public function testToCreatedAt()
    {
        $p1 = $this->createPost('Test1', '2020-02-20 10:00:00');
        $p2 = $this->createPost('Test2', '2020-02-19 10:00:00');
        $p3 = $this->createPost('Test3', '2020-02-16 10:00:00');
        $p4 = $this->createPost('Test4', '2020-02-18 10:00:00');

        $result = (new StreamQuery())->sort(Stream::SORT_CREATED_AT)->to($p2->content->id)->all();
        $this->assertCount(2, $result);

        $this->assertEquals($p4->message, $result[0]->getModel()->message);
        $this->assertEquals($p3->message, $result[1]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_UPDATED_AT in combination with to filter.
     * @throws Exception
     */
    public function testToUpdatedAt()
    {
        $p1 = $this->createPost('Test1', '2020-02-20 10:00:00');
        $p2 = $this->createPost('Test2', '2020-02-19 10:00:00');
        $p4 = $this->createPost('Test4', '2020-02-18 10:00:00');
        $p3 = $this->createPost('Test3', '2020-02-16 10:00:00');

        $result = (new StreamQuery())->sort(Stream::SORT_UPDATED_AT)->to($p4->content->id)->all();
        $this->assertCount(2, $result);

        $this->assertEquals($p1->message, $result[0]->getModel()->message);
        $this->assertEquals($p2->message, $result[1]->getModel()->message);
    }

    /**
     * Tests Stream::SORT_UPDATED_AT in combination with to filter while having entries with the same stream sort date.
     * This test should make sure that only content which was created after the search content is included in the result.
     * @throws Exception
     */
    public function testToUpdatedAtWithEqualDate()
    {
        $p1 = $this->createPost('Test1', '2020-02-18 10:00:00');
        $p2 = $this->createPost('Test2', '2020-02-18 10:00:00');
        $p4 = $this->createPost('Test4', '2020-02-18 10:00:00');
        $p3 = $this->createPost('Test3', '2020-02-16 10:00:00');

        $result = (new StreamQuery())->sort(Stream::SORT_UPDATED_AT)->to($p2->content->id)->all();
        // Result should include p3 and p4 whereas p1,p2,p4 have the same sort date but p1 was created prior to p2
        $this->assertCount(1, $result);

        $this->assertEquals($p1->message, $result[0]->getModel()->message);
    }
}
