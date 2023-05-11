<?php

namespace an602\modules\user\notifications;

use Yii;
use an602\modules\notification\components\NotificationCategory;

/**
 * Description of MentionedNotificationCategory
 *
 * @author buddha
 */
class MentionedNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = 'mentioned';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('UserModule.notification', 'Mentionings');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('UserModule.notification', 'Receive Notifications when someone mentioned you in a post.');
    }

}
