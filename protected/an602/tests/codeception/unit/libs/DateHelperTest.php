<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\tests\codeception\unit\libs;

use Codeception\Test\Unit;
use an602\libs\DateHelper;
use an602\libs\DbDateValidator;
use Yii;

/**
 * Class MimeHelperTest
 */
class DateHelperTest extends Unit
{
    public function _before()
    {
        parent::_before();
        Yii::$app->timeZone = 'Europe/Berlin';
        Yii::$app->formatter->timeZone =  'UTC';
    }

    public function testIsInDBFormat()
    {
        $this->assertFalse(DateHelper::isInDbFormat('2019-12-01'));
        $this->assertTrue(DateHelper::isInDbFormat('2019-12-01 12:30:00'));

        $this->assertFalse(DateHelper::isInDbFormat('2019-13-01'));
        $this->assertFalse(DateHelper::isInDbFormat('2019-13-01 12:30:00'));
    }
}
