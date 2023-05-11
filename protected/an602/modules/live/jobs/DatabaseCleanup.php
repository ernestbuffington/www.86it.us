<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live\jobs;

use Yii;
use an602\modules\live\models\Live;
use an602\modules\queue\ActiveJob;
use an602\modules\live\driver\Poll;

/**
 * DatabaseCleanup removes old live events
 *
 * @since 1.2
 * @author Luke
 */
class DatabaseCleanup extends ActiveJob
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->live->driver instanceof Poll) {
            Live::deleteAll('created_at +' . Yii::$app->live->driver->maxLiveEventAge . ' < ' . time());
        }
    }

}
