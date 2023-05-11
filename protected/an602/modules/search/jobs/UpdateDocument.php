<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\jobs;

use an602\components\ActiveRecord;
use an602\modules\queue\ActiveJob;
use an602\modules\queue\interfaces\ExclusiveJobInterface;
use an602\modules\search\interfaces\Searchable;
use Yii;

/**
 * UpdateDocument triggers an update in the search index.
 *
 * @since 1.3
 * @author Luke
 */
class UpdateDocument extends ActiveJob implements ExclusiveJobInterface
{

    /**
     * @var string class name of the active record
     */
    public $activeRecordClass;

    /**
     * @var int the primary key of the active record
     */
    public $primaryKey;


    /**
     * @inhertidoc
     */
    public function getExclusiveJobId()
    {
        return 'search.update.' . md5($this->activeRecordClass . $this->primaryKey);
    }

    /**
     * @inhertidoc
     */
    public function run()
    {
        $class = $this->activeRecordClass;
        if (is_subclass_of($class, ActiveRecord::class)) {
            $record = $class::findOne(['id' => $this->primaryKey]);
            if ($record !== null && $record instanceof Searchable) {
                Yii::$app->search->update($record);
            }
        }
    }

}
