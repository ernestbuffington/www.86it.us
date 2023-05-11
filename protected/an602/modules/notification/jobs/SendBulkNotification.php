<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\jobs;

use an602\modules\queue\ActiveJob;
use an602\modules\user\components\ActiveQueryUser;
use Yii;

/**
 * Description of SendNotification
 *
 * @author buddha
 * @since 1.2
 */
class SendBulkNotification extends ActiveJob
{
    /**
     * @var array Basenotification data as array.
     */
    public $notification;

    /**
     * @var ActiveQueryUser the query to determine which users should receive this notification
     */
    public $query;

    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->notification->sendBulk($this->notification, $this->query);
    }
}
