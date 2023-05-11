<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\console\Exception;
use an602\modules\search\interfaces\Searchable as SearchableInterface;

/**
 * Searchable Behavior
 *
 * @author Lucas Bartholemy <lucas@bartholemy.com>
 * @package an602.behaviors
 * @since 0.5
 */
class Searchable extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
        ];
    }

    public function afterSave($event)
    {

        if ($this->owner instanceof SearchableInterface) {
            Yii::$app->search->update($this->owner);
        } else {
            throw new Exception('Owner of HSearchableBehavior must be implement interface ISearchable');
        }
    }

    public function afterDelete($event)
    {
        if ($this->owner instanceof SearchableInterface) {
            Yii::$app->search->delete($this->owner);
        } else {
            throw new Exception('Owner of HSearchableBehavior must be implement interface ISearchable');
        }
    }

}
