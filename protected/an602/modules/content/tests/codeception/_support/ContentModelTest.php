<?php


namespace modules\content\tests\codeception\_support;


use an602\modules\content\models\Content;
use an602\modules\content\tests\codeception\unit\TestContent;
use an602\modules\space\models\Space;
use tests\codeception\_support\an602DbTestCase;

class ContentModelTest extends an602DbTestCase
{
    /**
     * @var TestContent
     */
    public $testModel;

    /**
     * @var Content
     */
    public $testContent;

    /**
     * @var Space
     */
    public $space;

    public function _before()
    {
        parent::_before();
        $this->becomeUser('User2');
        $this->space = Space::findOne(['id' => 2]);

        $this->testModel = new TestContent($this->space, Content::VISIBILITY_PUBLIC, [
            'message' => 'Test'
        ]);

        $this->assertTrue($this->testModel->save());

        $this->testContent = $this->testModel->content;
    }

}
