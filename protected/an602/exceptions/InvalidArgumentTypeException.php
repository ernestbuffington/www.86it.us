<?php

/**
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\exceptions;

use yii\base\InvalidArgumentException;

/**
 * @since 1.15
 */
class InvalidArgumentTypeException extends InvalidArgumentException
{
    use InvalidTypeExceptionTrait;

    protected function formatPrologue(array $constructArguments): string
    {
        $argumentName = is_array($this->parameter)
            ? reset($this->parameter)
            : null;
        $argumentNumber = is_array($this->parameter)
            ? key($this->parameter)
            : $this->parameter;

        $argumentName = $argumentName === null
            ? ''
            : " \$" . ltrim($argumentName, '$');

        return sprintf('Argument #%d%s', $argumentNumber, $argumentName);
    }
}
