<?php


namespace an602\libs;

/**
 * Class RestrictedCallException
 * @package an602\libs
 * @since 1.3.13
 */
class RestrictedCallException extends \Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Restricted Call';
    }
}