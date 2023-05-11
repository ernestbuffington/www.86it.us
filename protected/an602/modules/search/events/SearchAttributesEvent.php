<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\events;

use yii\base\Event;

/**
 * This event is used to collect additional search attributes for a record.
 *
 * The event object holds an reference to the search index attributes.
 * Modules like comments or files can add additional attributes to it.
 * 
 * @author luke
 * @since 1.2.3
 */
class SearchAttributesEvent extends Event
{

    /**
     * @var array Reference to the currently added search attributes
     */
    public $attributes;

    /**
     * @var \an602\modules\search\interfaces\Searchable the searchable record
     */
    public $record;

    /**
     * @inheritdoc
     */
    public function __construct(&$attributes, $record)
    {
        $this->attributes = &$attributes;
        $this->record = $record;

        $this->init();
    }

}
