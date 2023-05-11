<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace tests\codeception\unit\modules\content;

use DateTime;
use an602\modules\content\jobs\PublishScheduledContents;
use an602\modules\content\models\Content;
use an602\modules\content\widgets\WallCreateContentForm;
use an602\modules\post\models\Post;
use an602\modules\space\models\Space;
use tests\codeception\_support\an602DbTestCase;
use Yii;

class PublishScheduledContentTest extends an602DbTestCase
{
    public function testPublishScheduledContent()
    {
        $this->becomeUser('Admin');

        $postA = $this->createScheduledPost('-1 hour');
        $postB = $this->createScheduledPost('now');
        $postC = $this->createScheduledPost('1 hour');
        $postD = $this->createScheduledPost('tomorrow');

        (new PublishScheduledContents())->run();

        $postA = Post::findOne($postA->id);
        $this->assertEquals(Content::STATE_PUBLISHED, $postA->content->state);

        $postB = Post::findOne($postB->id);
        $this->assertEquals(Content::STATE_PUBLISHED, $postB->content->state);

        $postC = Post::findOne($postC->id);
        $this->assertEquals(Content::STATE_SCHEDULED, $postC->content->state);

        $postD = Post::findOne($postD->id);
        $this->assertEquals(Content::STATE_SCHEDULED, $postD->content->state);
    }

    private function createScheduledPost($date): Post
    {
        $datetime = (new DateTime($date))->format('Y-m-d H:i:s');

        $space = Space::findOne(1);
        $post = new Post($space, ['message' => 'Post for test scheduling']);
        Yii::$app->request->setBodyParams([
            'state' => Content::STATE_SCHEDULED,
            'scheduledDate' => $datetime
        ]);

        $result = WallCreateContentForm::create($post, $space);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals(Content::STATE_SCHEDULED, $post->content->state);
        $this->assertEquals($datetime, $post->content->scheduled_at);

        return $post;
    }
}
