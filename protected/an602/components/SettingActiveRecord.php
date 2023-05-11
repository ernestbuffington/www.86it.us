<?php

/**
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\components;

use Yii;
use yii\base\InvalidCallException;
use yii\db\ActiveRecord;

/**
 * BaseSetting
 *
 * @since  1.13.2
 * @author Martin Rüegg <martin.rueegg@metaworx.ch>
 */
abstract class SettingActiveRecord extends ActiveRecord
{
    /**
     * @const array List of fields to be used to generate the cache key
     */
    public const CACHE_KEY_FIELDS = ['module_id'];

    /**
     * @const string Used as the formatting pattern for sprintf when generating the cache key
     */
    public const CACHE_KEY_FORMAT = 'settings-%s';

    /**
     * @param string|array|null $condition
     * @param array $params
     *
     * @return int
     * @noinspection PhpMissingReturnTypeInspection
     */
    public static function deleteAll($condition = null, $params = [])
    {
        if (static::class === self::class) {
            throw new InvalidCallException(sprintf(
                'Method %s may not be called from the abstract class, but MUST be called from the implementing class, as otherwise tablename() is not returning a correct table.',
                __METHOD__
            ));
        }

        // get a grouped list of cache entries that are going to be deleted, grouped by static::CACHE_KEY_FIELDS
        $modulesOrContainers = self::find()
            ->where($condition, $params)
            ->groupBy(static::CACHE_KEY_FIELDS)
            ->select(static::CACHE_KEY_FIELDS)
            ->all();

        // going through that list, deleting the respective cache
        array_walk($modulesOrContainers, static function (ActiveRecord $rec) {
            $key = static::getCacheKey(...array_values($rec->toArray()));
            Yii::$app->cache->delete($key);
        });

        // proceed to delete the records from the database
        return parent::deleteAll($condition, $params);
    }

    /**
     * @param string $moduleId Name of the module to create the cache key for
     * @param mixed ...$values Additional arguments, if required by the static::CACHE_KEY_FORMAT
     *
     * @return string The key used for cache operation
     */
    public static function getCacheKey(string $moduleId, ...$values): string
    {
        return sprintf(static::CACHE_KEY_FORMAT, $moduleId, ...$values);
    }
}
