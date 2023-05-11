<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\filter\models;

use yii\db\ActiveQuery;

abstract class QueryFilter extends Filter
{
    /**
     * @var ActiveQuery
     */
    public $query;
}
