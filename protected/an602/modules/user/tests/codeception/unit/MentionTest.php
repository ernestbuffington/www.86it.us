<?php

namespace an602\modules\user\tests\codeception\unit;

use an602\modules\comment\models\Comment;
use an602\modules\content\widgets\richtext\ProsemirrorRichText;
use an602\modules\content\widgets\richtext\RichText;
use an602\modules\post\models\Post;
use an602\modules\space\models\Space;
use an602\modules\user\models\Mentioning;
use an602\modules\user\notifications\Mentioned;
use tests\codeception\_support\an602DbTestCase;

class MentionTest extends an602DbTestCase
{

    /**
     * @throws \yii\base\Exception
     */
    public function testPostMention()
    {
        $this->becomeUser('User2');
        $space = Space::findOne(['id' => 1]);

        $post = new Post(['message' => ' [url](mention:01e50e0d-82cd-41fc-8b0c-552392f5839c "url")']);
        $post->content->container = $space;
        $post->save();

        RichText::postProcess($post->message, $post);

        $this->assertHasNotification(Mentioned::class, $post);
        $this->assertMailSent(1, 'Mentioned Notification');
    }

    public function testMentionAuthor()
    {
        $this->becomeUser('User2');

        // Mention Admin in Space 1 (Admin is author of post)
        $comment = new Comment([
            'message' => 'Hi [url](mention:01e50e0d-82cd-41fc-8b0c-552392f5839c "url")',
            'object_model' => Post::class,
            'object_id' => 7
        ]);

        $comment->save();

        $this->assertHasNotification(Mentioned::class, $comment);

        // We expect only the Mentioned mail
        $this->assertMailSent(1, 'Comment Notification Mail sent');
    }

    public function testMentionNonAuthor()
    {
        $this->becomeUser('User2');

        // Mention User1 in post
        $comment = new Comment([
            'message' => 'Hi [url](mention:01e50e0d-82cd-41fc-8b0c-552392f5839d "url")',
            'object_model' => Post::class,
            'object_id' => 7
        ]);

        $comment->save();

        $this->assertHasNotification(Mentioned::class, $comment);

        // Commented mail for Admin and Mentioned mail for User1
        $this->assertMailSent(2, 'Comment Notification Mail sent');
    }
}
