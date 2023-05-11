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
 * DeleteDocument triggers a delete in the search index.
 *
 * @since 1.3
 * @author Luke
 */
class DeleteDocument extends ActiveJob implements ExclusiveJobInterface
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
        return 'search.delete.' . md5($this->activeRecordClass . $this->primaryKey);
    }

    /**
     * @inhertidoc
     */
    public function run()
    {
        // Temporary check until offical search api change
        if (method_exists(Yii::$app->search, 'deleteRecord')) {
            Yii::$app->search->deleteRecord($this->activeRecordClass, $this->primaryKey);
        }
    }

}
