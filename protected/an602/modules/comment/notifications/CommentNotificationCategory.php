<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\notifications;

use Yii;
use an602\modules\notification\components\NotificationCategory;

/**
 * CommentNotificationCategory
 *
 * @author buddha
 */
class CommentNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = "comments";

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('CommentModule.notification', 'Receive Notifications when someone comments on my own or a following post.');
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('CommentModule.notification', 'Comments');
    }

}
