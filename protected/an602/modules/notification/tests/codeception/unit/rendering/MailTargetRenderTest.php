<?php

namespace an602\modules\notification\tests\codeception\unit\rendering;

use Yii;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\notification\targets\MailTarget;

class MailTargetRenderTest extends an602DbTestCase
{

    use Specify;

    public function testDefaultView()
    {
        $notification = notifications\TestNotification::instance();
        $target = Yii::$app->notification->getTarget(MailTarget::class);
        $renderer = $target->getRenderer();
        $this->assertStringContainsString('<h1>TestedMailViewNotificationHTML</h1>', $renderer->render($notification));
        $this->assertStringContainsString('TestedMailViewNotificationText', $renderer->renderText($notification));
    }

}
