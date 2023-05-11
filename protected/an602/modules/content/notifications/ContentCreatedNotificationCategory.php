<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\notifications;

use Yii;
use an602\modules\notification\components\NotificationCategory;

/**
 * Description of ContentCreatedNotificationCategory
 *
 * @author buddha
 */
class ContentCreatedNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = "content_created";

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('ContentModule.notifications', 'Receive Notifications for new content you follow.');
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('ContentModule.notifications', 'New Content');
    }

}
