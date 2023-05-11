<?php

/*
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\tests\codeception\unit\components;

use Codeception\Test\Unit;
use an602\libs\BaseSettingsManager;
use tests\codeception\_support\an602DbTestCase;

class BaseSettingsManagerTest extends an602DbTestCase
{
    public function testIsDatabaseInstalled()
    {
        $this->assertTrue(BaseSettingsManager::isDatabaseInstalled());
    }
}
