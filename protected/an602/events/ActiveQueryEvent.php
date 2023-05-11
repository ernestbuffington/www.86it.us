<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\events;

use yii\base\Event;
use yii\db\ActiveQuery;

/**
 * ActiveQueryEvent represents the parameter needed by [[ActiveQuery]] events.
 * 
 * @since 1.2.3
 * @author Luke
 */
class ActiveQueryEvent extends Event
{

    /**
     * @var ActiveQuery the active query
     */
    public $query;
}
