<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\notifications;

use Yii;
use an602\modules\notification\components\NotificationCategory;

/**
 * Description of FollowingNotificationCategory
 *
 * @author buddha
 */
class FollowedNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = 'followed';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('UserModule.notification', 'Following');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('UserModule.notification', 'Receive Notifications when someone is following you.');
    }

}
