<?php

/**
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\exceptions;

use yii\base\InvalidConfigException;

/**
 * @since 1.15
 */
class InvalidConfigTypeException extends InvalidConfigException
{
    use InvalidTypeExceptionTrait;

    protected function formatPrologue(array $constructArguments): string
    {
        return "Parameter $this->parameter of configuration";
    }
}
