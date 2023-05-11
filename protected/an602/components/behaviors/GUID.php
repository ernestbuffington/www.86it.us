<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
 * GUID Behavior
 *
 * @author Lucas Bartholemy <lucas@bartholemy.com>
 * @package an602.behaviors
 * @since 0.5
 */
class GUID extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setGuid',
            ActiveRecord::EVENT_BEFORE_INSERT => 'setGuid',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setGuid',
        ];
    }

    public function setGuid($event)
    {
        if ($this->owner->isNewRecord) {
            if ($this->owner->guid == "") {
                $this->owner->guid = \an602\libs\UUID::v4();
            }
        }
    }
}
