<?php


namespace an602\modules\user\tests\codeception\_support;


use an602\modules\content\models\Content;
use an602\modules\post\models\Post;
use an602\modules\user\models\User;
use an602\modules\user\stream\ProfileStreamQuery;
use tests\codeception\_support\an602DbTestCase;

class ProfileStreamTest extends an602DbTestCase
{
    /**
     * @var User
     */
    protected $user;

    public function _before()
    {
        Post::deleteAll();
        Content::deleteAll();
        $this->enableFriendships(false);
        $this->user = $this->becomeUser('User1');
    }

    /**
     * @return ProfileStreamQuery
     */
    protected function createQuery($includeContributions = true)
    {
        return new ProfileStreamQuery(['container' => $this->user, 'includeContributions' => $includeContributions]);
    }

    protected function createProfilePost($visibility, $message = 'My first post!')
    {
        return $this->createPost($this->user, $visibility, $message);
    }

    protected function createPost($container, $visibility, $message = 'My first post!')
    {
        $post = new Post($container, $visibility, ['message' => $message]);
        $this->assertTrue($post->save());
        return $post;
    }
}
