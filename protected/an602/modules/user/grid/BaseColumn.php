<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\grid;

use yii\db\ActiveRecord;
use yii\grid\DataColumn;

/**
 * BaseColumn for user grid fields
 *
 * @since 1.3
 * @author Luke
 */
abstract class BaseColumn extends DataColumn
{

    /**
     * @var string|null name of user attribute
     */
    public $userAttribute = null;

    /**
     * Returns the user record 
     * 
     * @param ActiveRecord $record
     * @return \an602\modules\user\models\User the user model
     */
    public function getUser(ActiveRecord $record)
    {
        if ($this->userAttribute === null) {
            return $record;
        }

        $attributeName = $this->userAttribute;
        return $record->$attributeName;
    }

}
