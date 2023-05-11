<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\tests\codeception\unit;

use Codeception\Test\Unit;
use Yii;

class FormatterTest extends Unit
{
    public function testAsShortInteger()
    {
        $testNumbers = [
            1 => '1',
            12 => '12',
            123 => '123',
            999 => '999',
            1000 => '1K',
            1234 => '1K',
            9990 => '9K',
            123456 => '123K',
            123999 => '123K',
            999999 => '999K',
            1234567 => '1M',
            123456789 => '123M',
            123999500 => '124M',
            999999499 => '999M',
            999999500 => '1000M',
            1234567899 => '1B',
            123456789999 => '123B',
            12345678999999 => '12345B',
            999999999499999 => '999999B',
            999999999500000 => '1000000B',
        ];
        foreach ($testNumbers as $numberValue => $result) {
            $this->assertEquals(Yii::$app->formatter->asShortInteger($numberValue), $result);
        }
    }
}
