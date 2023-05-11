<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\jobs;

use an602\modules\notification\components\BaseNotification;
use an602\modules\user\models\User;
use Yii;
use an602\modules\queue\ActiveJob;

/**
 * Description of SendNotification
 *
 * @author buddha
 * @since 1.2
 */
class SendNotification extends ActiveJob
{
    /**
     * @var BaseNotification notification instance
     */
    public $notification;

    /**
     * @var int the user id of the recipient
     */
    public $recipientId;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $recipient = User::findOne(['id' => $this->recipientId]);
        if ($recipient !== null) {
            Yii::$app->notification->send($this->notification, $recipient);
        }
    }
}
