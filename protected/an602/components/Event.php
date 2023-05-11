<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components;

/**
 * Event is the base class for all event classes.
 *
 * @since 1.2.3
 * @author Luke
 */
class Event extends \yii\base\Event
{

    /**
     * @var mixed an optional result which can be manipulated by the event handler.
     * Note that this varies according to which event is currently executing.
     */
    public $result;
}
