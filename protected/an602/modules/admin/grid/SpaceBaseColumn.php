<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\grid;

use yii\db\ActiveRecord;
use yii\grid\DataColumn;

/**
 * BaseColumn for space grid fields
 *
 * @since 1.3
 * @author Luke
 */
abstract class SpaceBaseColumn extends DataColumn
{

    /**
     * @var string|null name of space model attribute
     */
    public $spaceAttribute = null;

    /**
     * Returns the space record 
     * 
     * @param ActiveRecord $record
     * @return \an602\modules\space\models\Space the space model
     */
    public function getSpace(ActiveRecord $record)
    {
        if ($this->spaceAttribute === null) {
            return $record;
        }

        $attributeName = $this->spaceAttribute;
        return $record->$attributeName;
    }

}
