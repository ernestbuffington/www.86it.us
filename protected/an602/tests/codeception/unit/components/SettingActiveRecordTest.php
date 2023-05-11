<?php

/*
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\tests\codeception\unit\components;

use an602\components\SettingActiveRecord;
use an602\models\Setting;
use tests\codeception\_support\an602DbTestCase;
use yii\base\InvalidCallException;

class SettingActiveRecordTest extends an602DbTestCase
{
    public function testGetCacheKeyFormat()
    {
        $this->assertEquals('settings-%s', SettingActiveRecord::CACHE_KEY_FORMAT, "Cache key format changed!");
    }

    public function testGetCacheKeyFields()
    {
        $this->assertEquals(['module_id'], SettingActiveRecord::CACHE_KEY_FIELDS, "Cache key format changed!");
    }

    public function testGetCacheKey()
    {
        $cacheKey = Setting::getCacheKey('test');
        $this->assertEquals('settings-test', $cacheKey, "Cache key malformed!");

        $cacheKey = Setting::getCacheKey('test', 'more');
        $this->assertEquals('settings-test', $cacheKey, "Cache key malformed!");
    }

    public function testDeleteAll()
    {
        $this->expectException(InvalidCallException::class);
        $this->expectExceptionMessageRegExp(sprintf('@%s@', str_replace('\\', '\\\\', SettingActiveRecord::class)));

        SettingActiveRecord::deleteAll();
    }
}
