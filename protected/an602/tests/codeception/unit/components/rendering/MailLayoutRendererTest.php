<?php

namespace an602\tests\codeception\unit;

use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\tests\codeception\unit\components\rendering\lib\TestViewable;
use an602\components\rendering\MailLayoutRenderer;

class MailLayoutRendererTest extends an602DbTestCase
{

    use Specify;

    public function testExistingTextView()
    {
        $viewable = new TestViewable(['viewName' => 'parent']);
        $renderer = new MailLayoutRenderer(['parent' => true,
            'textLayout' => '@tests/codeception/unit/components/rendering/views/layouts/testLayout.php']);
        $this->assertEquals('TestLayout:TestViewText', $renderer->renderText($viewable));
    }

    public function testNoLayoutRenderText()
    {
        $viewable = new TestViewable(['viewName' => 'parent']);
        $renderer = new MailLayoutRenderer(['parent' => true]);
        $this->assertEquals('TestViewText', $renderer->renderText($viewable));
    }
    
    public function testNonExistingTextLayout()
    {
        try {
            $viewable = new TestViewable(['viewName' => 'nonExisting']);
            $renderer = new MailLayoutRenderer(['textLayout' => '@tests/codeception/unit/components/rendering/views/layouts/nonExsting.php']);
            $renderer->renderText($viewable);
            $this->assertTrue(false);
        } catch (\yii\base\ViewNotFoundException $ex) {
            $this->assertTrue(true);
        }
    }
}
