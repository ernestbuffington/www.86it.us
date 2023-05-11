<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content;

use tests\codeception\_support\an602DbTestCase;
use an602\modules\post\models\Post;

use an602\modules\space\models\Space;
use an602\modules\content\models\Content;

class ContentEditTest extends an602DbTestCase
{

    public function testNewContentIsNotEdited()
    {
        $this->becomeUser('User2');
        $space = Space::findOne(['id' => 2]);

        $post1 = new Post($space, Content::VISIBILITY_PUBLIC, ['message' => 'Test']);
        $this->assertTrue($post1->save());
        $this->assertFalse($post1->content->isUpdated());

        // Reload content
        $post1 = Post::findOne(['id' => $post1->id]);
        $this->assertFalse($post1->content->isUpdated());
    }

    public function testEditedContentIsEdited()
    {
        $this->becomeUser('User2');
        $space = Space::findOne(['id' => 2]);

        $post1 = new Post($space, Content::VISIBILITY_PUBLIC, ['message' => 'Test']);
        $this->assertTrue($post1->save());

        // Wait a second in order to prevent created_at = edited_at
        sleep(1);

        // Reload content
        $post1 = Post::findOne(['id' => $post1->id]);
        $post1->message = 'Updated Message';
        $this->assertTrue($post1->save());


        $this->assertTrue($post1->content->isUpdated());

        // Reload content
        $post1 = Post::findOne(['id' => $post1->id]);
        $this->assertTrue($post1->content->isUpdated());
    }

}
