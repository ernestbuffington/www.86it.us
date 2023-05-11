<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\events;

use yii\base\Event;

/**
 * This event is used when an object is added to search index
 *
 * @author luke
 * @since 0.21
 */
class SearchAddEvent extends Event
{

    /**
     * @var array Reference to the currently added search attributes
     */
    public $attributes;

    /**
     * @inheritdoc
     */
    public function __construct(&$attributes)
    {
        $this->attributes = &$attributes;
        $this->init();
    }

}
