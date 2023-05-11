<?php

namespace tests\codeception\unit;

use an602\modules\user\widgets\UserPickerField;
use tests\codeception\_support\an602DbTestCase;

class UserPickerFieldTest extends an602DbTestCase
{
    public function testItemKey()
    {
        $picker = new UserPickerField();
        $this->assertEquals('guid', $picker->itemKey);

        $picker = new UserPickerField(['itemKey' => 'id']);
        $this->assertEquals('id', $picker->itemKey);
    }

    public function testDefaultRoute()
    {
        $picker = new UserPickerField();
        $this->assertEquals('/user/search/json', $picker->defaultRoute);
    }
}
