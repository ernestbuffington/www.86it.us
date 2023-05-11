<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content;

use Yii;
use an602\modules\friendship\models\Friendship;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\post\models\Post;

use an602\modules\space\models\Space;
use an602\modules\content\models\Content;
use an602\modules\stream\actions\ContentContainerStream;

class ProfileContentPermissionTest extends an602DbTestCase
{

    /**
     *  - User is the owner of the content
     *  - User is system administrator and the content module setting `adminCanEditAllContent` is set to true (default)
     *  - The user is granted the managePermission set by the model record class
     *  - The user meets the additional condition implemented by the model records class own `canEdit()` function.
     */
    use Specify;

    public $privatePost;
    public $publicPost;
    public $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->becomeUser('Admin');
        $this->admin = User::findOne(['id' => 1]);

        $this->privatePost = new Post;
        $this->privatePost->message = "Private Space1 Post";
        $this->privatePost->content->setContainer($this->admin);
        $this->privatePost->content->visibility = Content::VISIBILITY_PRIVATE;
        $this->privatePost->save();

        $this->publicPost = new Post;
        $this->publicPost->message = "Public Space1 Post";
        $this->publicPost->content->setContainer($this->admin);
        $this->publicPost->content->visibility = Content::VISIBILITY_PUBLIC;
        $this->publicPost->save();
    }

    public function testOwnerPermissions()
    {
        $this->assertTrue($this->privatePost->content->canView());
        $this->assertTrue($this->publicPost->content->canView());
        $this->assertTrue($this->publicPost->content->canEdit());
        $this->assertTrue($this->privatePost->content->canEdit());
    }

    public function testOtherUserPermissions()
    {
        $user3 = User::findOne(['id' => 4]);
        $this->becomeUser('User3');

        $this->reloadPosts();

        $this->assertFalse($this->privatePost->content->canView());
        $this->assertTrue($this->publicPost->content->canView());
        $this->assertFalse($this->publicPost->content->canEdit());
        $this->assertFalse($this->privatePost->content->canEdit());
    }

    public function testFriendPermissions()
    {
        Yii::$app->getModule('friendship')->settings->set('enable', true);
        $user3 = User::findOne(['id' => 4]);
        $this->becomeUser('User3');

        Friendship::add($this->admin, $user3);
        Friendship::add($user3, $this->admin);
        $this->reloadPosts();

        $this->assertTrue($this->privatePost->content->canView());
        $this->assertTrue($this->publicPost->content->canView());
        $this->assertFalse($this->publicPost->content->canEdit());
        $this->assertFalse($this->privatePost->content->canEdit());

        // Disable friendship system
        Yii::$app->getModule('friendship')->settings->set('enable', false);

        $this->reloadPosts();

        $this->assertFalse($this->privatePost->content->canView());
        $this->assertTrue($this->publicPost->content->canView());
        $this->assertFalse($this->publicPost->content->canEdit());
        $this->assertFalse($this->privatePost->content->canEdit());
    }

    public function testProfileGuestPermissions()
    {
        // Allow Guest Access
        Yii::$app->getModule('user')->settings->set('auth.allowGuestAccess', true);
        $this->logout();

        $this->admin->visibility = User::VISIBILITY_REGISTERED_ONLY;
        $this->admin->save();

        // Test Guest Access with Profile visiblity ONLY REGISTERED
        $this->reloadPosts();

        $this->assertFalse($this->privatePost->content->canView());
        $this->assertFalse($this->publicPost->content->canView());
        $this->assertFalse($this->publicPost->content->canEdit());
        $this->assertFalse($this->privatePost->content->canEdit());

        // Test Guest Access with Profile visiblity ALL
        $this->admin->visibility = User::VISIBILITY_ALL;
        $this->admin->save();

        $this->reloadPosts();

        $this->assertFalse($this->privatePost->content->canView());
        $this->assertTrue($this->publicPost->content->canView());
        $this->assertFalse($this->publicPost->content->canEdit());
        $this->assertFalse($this->privatePost->content->canEdit());

        // Disable Guest Access
        Yii::$app->getModule('user')->settings->set('auth.allowGuestAccess', false);

        $this->reloadPosts();

        $this->assertFalse($this->privatePost->content->canView());
        $this->assertFalse($this->publicPost->content->canView());
        $this->assertFalse($this->publicPost->content->canEdit());
        $this->assertFalse($this->privatePost->content->canEdit());
    }

    public function reloadPosts()
    {
        $this->privatePost = Post::findOne(['id' => $this->privatePost->id]);
        $this->publicPost = Post::findOne(['id' => $this->publicPost->id]);
    }
}
