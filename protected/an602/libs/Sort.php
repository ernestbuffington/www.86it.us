<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\libs;

/**
 * Class Sort
 *
 * @package an602\libs
 */
class Sort
{

    /**
     * @param array $arr The input array.
     * @param string $field The attribute or array key to which holds the sort order
     * @param int $default The default sort order if field value is empty. Default PHP_INT_MAX
     *
     * @return array the sorted array
     */
    public static function sort(&$arr, $field = 'sortOrder', $default = PHP_INT_MAX)
    {
        usort($arr, function ($a, $b) use ($field, $default) {
            $sortA = static::getSortValue($a, $field, $default);
            $sortB = static::getSortValue($b, $field, $default);

            if ($sortA == $sortB) {
                return 0;
            } elseif ($sortA < $sortB) {
                return -1;
            } else {
                return 1;
            }
        });

        return $arr;
    }

    /**
     * @param array|object $obj the object or array
     * @param string $field the field name
     * @param int $default the default sort order
     * @return int
     */
    private static function getSortValue($obj, $field, $default)
    {
        if (is_array($obj) && isset($obj[$field])) {
            return $obj[$field] === null ? $default : $obj[$field];
        }

        if (property_exists($obj, $field)) {
            return $obj->$field === null ? $default : $obj->$field;
        }

        return PHP_INT_MAX;
    }

}
