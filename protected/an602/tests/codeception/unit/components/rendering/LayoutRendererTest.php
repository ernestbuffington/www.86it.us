<?php

namespace an602\tests\codeception\unit;

use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\tests\codeception\unit\components\rendering\lib\TestViewable;
use an602\components\rendering\LayoutRenderer;

class LayoutRendererTest extends an602DbTestCase
{

    use Specify;

    public function testSimpleViewPathRenderer()
    {
        $viewable = new TestViewable(['viewName' => 'parent']);
        $renderer = new LayoutRenderer(['parent' => true, 'layout' => '@tests/codeception/unit/components/rendering/views/layouts/testLayout.php']);
        $this->assertEquals('<div>TestLayout:<h1>ParentView:TestTitle</h1></div>', $renderer->render($viewable));
    }
    
    public function testNoLayout()
    {
        $viewable = new TestViewable(['viewName' => 'parent']);
        $renderer = new LayoutRenderer(['parent' => true]);
        $this->assertEquals('<h1>ParentView:TestTitle</h1>', $renderer->render($viewable));
    }
}
