<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\interfaces;

/**
 * Interface for Searchable Models
 *
 * @package an602.interfaces
 * @since 0.5
 * @author Luke
 */
interface Searchable
{

    const EVENT_SEARCH_ADD = 'searchadd';

    public function getWallOut();

    public function getSearchAttributes();
}
