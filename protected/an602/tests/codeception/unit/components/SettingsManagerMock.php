<?php

/*
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\tests\codeception\unit\components;

use an602\components\SettingsManager;

class SettingsManagerMock extends SettingsManager
{
    public bool $usedFind = false;

    protected function find()
    {
        $this->usedFind = true;

        return parent::find();
    }

    public function getCacheKey(): string
    {
        return parent::getCacheKey();
    }

    /**
     * @return bool
     */
    public function didAccessDB(): bool
    {
        $read = $this->usedFind;
        $this->usedFind = false;
        return $read;
    }

    public function invalidateCache()
    {
        parent::invalidateCache();
    }
}
