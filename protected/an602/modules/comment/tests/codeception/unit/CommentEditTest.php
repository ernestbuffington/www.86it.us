<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content;

use an602\modules\comment\models\Comment;
use tests\codeception\_support\an602DbTestCase;
use an602\modules\post\models\Post;

class CommentEditTest extends an602DbTestCase
{

    public function testNewCommentIsNotEdited()
    {
        $this->becomeUser('User2');
        $comment = new Comment([
            'message' => 'User2 comment!',
            'object_model' => Post::class,
            'object_id' => 11
        ]);

        $this->assertTrue($comment->save());
        $this->assertFalse($comment->isUpdated());

        // Reload content
        $comment = Comment::findOne(['id' => $comment->id]);
        $this->assertFalse($comment->content->isUpdated());
    }

    public function testEditedContentIsEdited()
    {
        $this->becomeUser('User2');
        $comment = new Comment([
            'message' => 'User2 comment!',
            'object_model' => Post::class,
            'object_id' => 11
        ]);

        $this->assertTrue($comment->save());

        // Wait a second in order to prevent created_at = edited_at
        sleep(1);

        // Reload content
        $comment = Comment::findOne(['id' => $comment->id]);
        $comment->message = 'Updated Message';
        $this->assertTrue($comment->save());

        // See https://github.com/an602/an602/issues/4381
        $comment->refresh();
        $this->assertTrue($comment->isUpdated());

        // Reload content
        $comment = Comment::findOne(['id' => $comment->id]);
        $this->assertTrue($comment->isUpdated());
    }

}
