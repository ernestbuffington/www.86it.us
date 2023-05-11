<?php

namespace an602\modules\notification\tests\codeception\unit\rendering;

use an602\modules\post\models\Post;
use an602\modules\user\models\User;
use Yii;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\notification\targets\WebTarget;

class WebTargetRenderTest extends an602DbTestCase
{

    use Specify;

    public function testDefaultView()
    {
        $notification = notifications\TestNotification::instance()->about(Post::findOne(['id' => 1]));
        $notification->send(User::findOne(['id' => 1]));

        $target = Yii::$app->notification->getTarget(WebTarget::class);
        $renderer = $target->getRenderer();
        $result = $renderer->render($notification);
        $this->assertStringContainsString('New', $result);
        $this->assertStringContainsString('<h1>TestedMailViewNotificationHTML</h1>', $result);
    }

    public function testOverwriteViewFile()
    {
        $notification = notifications\TestNotification::instance()->about(Post::findOne(['id' => 1]));
        $notification->send(User::findOne(['id' => 1]));
        $notification->viewName = 'special';
        $notification->saveRecord(User::findOne(['id' => 1]));
        $target = Yii::$app->notification->getTarget(WebTarget::class);
        $renderer = $target->getRenderer();
        $result = $renderer->render($notification);
        $this->assertStringContainsString('New', $result);
        $this->assertStringContainsString('<div>Special:<h1>TestedMailViewNotificationHTML</h1></div>', $result);
    }

}
