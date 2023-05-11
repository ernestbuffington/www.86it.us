<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\libs;

use yii\base\Event;

/**
 * This event holds references to parameters which can be modified.
 *
 * @author luke
 * @since 0.21
 */
class ParameterEvent extends Event
{

    /**
     * @var array the parameter references
     */
    public $parameters;

    /**
     * @inheritdoc
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $this->init();
    }
}
