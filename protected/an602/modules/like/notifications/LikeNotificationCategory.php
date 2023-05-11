<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\like\notifications;

use Yii;
use an602\modules\notification\components\NotificationCategory;
use an602\modules\notification\targets\BaseTarget;
use an602\modules\notification\targets\MailTarget;

/**
 * LikeNotificationCategory
 *
 * @author buddha
 */
class LikeNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = 'like';

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target instanceof MailTarget) {
            return false;
        }

        return parent::getDefaultSetting($target);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('LikeModule.notifications', 'Likes');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('LikeModule.notifications', 'Receive Notifications when someone likes your content.');
    }

}
