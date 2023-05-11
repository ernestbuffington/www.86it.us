<?php

namespace tests\codeception\unit\modules\like;

use Yii;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\like\models\Like;
use an602\modules\post\models\Post;

class LikeTest extends an602DbTestCase
{

    use Specify;

    public function testLikePost()
    {
        $this->becomeUser('User2');

        $like = new Like([
            'object_model' => Post::class,
            'object_id' => 1
        ]);
        
        Yii::$app->getModule('notification')->settings->user(User::findOne(['id' => 1]))->set('notification.like_email', 1);

        $this->assertTrue($like->save(), 'Save like.');
        $this->assertMailSent(1, 'Like notification sent');
        $this->assertHasNotification(\an602\modules\like\notifications\NewLike::class, $like);
        $this->assertHasActivity(\an602\modules\like\activities\Liked::class, $like);
    }

}
