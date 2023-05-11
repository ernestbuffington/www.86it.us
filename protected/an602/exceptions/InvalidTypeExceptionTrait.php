<?php

/**
 * @link      https://www.an602.org/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license   https://www.an602.com/licences
 */

namespace an602\exceptions;

/**
 * @since 1.15
 */
trait InvalidTypeExceptionTrait
{
    //  public properties

    public string $methodName;
    public $parameter;
    public array $validType = [];

    /**
     * @var mixed|null
     */
    public $givenValue;

    /**
     * @param string $method
     * @param int|array $parameter = [
     *                                     int => string,       // position, or [ position => name ] of the  argument
     *                                     ]
     * @param array|string|null $validType
     * @param null $givenValue
     */
    public function __construct(
        $method = '',
        $parameter = null,
        $validType = [],
        $givenValue = null,
        $nullable = false,
        $code = 0,
        $previous = null
    ) {

        $this->methodName = $method;
        $this->parameter = $parameter;
        $this->validType = (array)($validType ?? ['mixed']);
        $this->givenValue = $givenValue;

        if ($nullable && !in_array('null', $this->validType, true)) {
            $this->validType[] = 'null';
        }

        $message = sprintf(
            '%s passed to %s must be of type %s, %s given.',
            $this->formatPrologue(func_get_args()),
            $this->methodName,
            implode(', ', $this->validType),
            get_debug_type($this->givenValue)
        );

        parent::__construct($message, $code, $previous);
    }

    abstract protected function formatPrologue(array $constructArguments): string;

    public function getName(): string
    {
        if (method_exists(parent::class, 'getName')) {
            return parent::getName() . " Type";
        }

        return 'Invalid Type';
    }
}
