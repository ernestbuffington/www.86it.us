<?php

namespace an602\tests\codeception\unit;

use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\tests\codeception\unit\components\rendering\lib\TestViewable;
use an602\components\rendering\MailRenderer;

class MailRendererTest extends an602DbTestCase
{

    use Specify;

    public function testExistingTextView()
    {
        $viewable = new TestViewable(['viewName' => 'testView']);
        $renderer = new MailRenderer(['parent' => true, 
            'defaultTextView' => '@tests/codeception/unit/components/rendering/lib/views',
            'defaultTextViewPath' => '@tests/codeception/unit/components/rendering/lib/views/specialView.php']);
        $this->assertEquals('TextView:TestTitle', $renderer->renderText($viewable));
    }
    
    public function testNonExistingTextView()
    {
        $viewable = new TestViewable(['viewName' => 'nonExisting']);
        $renderer = new MailRenderer(['parent' => true, 
            'defaultTextView' => '@tests/codeception/unit/components/rendering/lib/views/testView.php',
            'defaultTextViewPath' => '@tests/codeception/unit/components/rendering/lib/views']);
        $this->assertEquals('TestTitle', $renderer->renderText($viewable));
    }
    
    public function testExistingViewPathTextView()
    {
        $viewable = new TestViewable(['viewName' => 'specialView']);
        $renderer = new MailRenderer(['parent' => true, 
            'defaultTextView' => '@tests/codeception/unit/components/rendering/lib/views/testView.php',
            'defaultTextViewPath' => '@tests/codeception/unit/components/rendering/lib/views']);
        $this->assertEquals('SpecialView', $renderer->renderText($viewable));
    }
   
}
