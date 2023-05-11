<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content\widgets;

use an602\modules\content\widgets\richtext\RichText;
use tests\codeception\_support\an602DbTestCase;


class RichtextPreviewTest extends an602DbTestCase
{
    public function testStripHtml()
    {
        $this->assertEquals('&lt;b&gt;Test&lt;/b&gt;', RichText::preview('<b>Test</b>'));
    }

    public function testNewLine()
    {
        $this->assertEquals('Te\\nst', RichText::preview('Te\\nst'));
    }

    public function testAmpEntity()
    {
        $this->assertEquals('test &amp; test', RichText::preview('test & test'));
    }

    public function testQuoteEntity()
    {
        $this->assertEquals('test &#039; test', RichText::preview('test \' test'));
    }

    public function testSimpleLink()
    {
        $this->assertEquals('Test: Github', RichText::preview('Test: [Github](https://github.com)'));
    }

    public function testEmoji()
    {
        $this->assertEquals('Test: 😃', RichText::preview('Test: :smiley:'));
    }

    public function testMultipleEmoji()
    {
        $this->assertEquals('Test: 😃 😍 👎', RichText::preview('Test: :smiley: :heart_eyes: :-1:'));
    }

    public function testMentioning()
    {
        $this->assertEquals('Test: @Admin Tester', RichText::preview('Test: [Admin Tester](mention:01e50e0d-82cd-41fc-8b0c-552392f5839c "/an602/develop/index.php?r=user%2Fprofile&cguid=01e50e0d-82cd-41fc-8b0c-552392f5839c")'));
    }
}
