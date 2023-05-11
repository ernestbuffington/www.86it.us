<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\notifications;

use an602\modules\user\models\User;
use Yii;
use an602\modules\notification\components\NotificationCategory;
use an602\modules\notification\targets\BaseTarget;
use an602\modules\notification\targets\MailTarget;
use an602\modules\notification\targets\WebTarget;
use an602\modules\notification\targets\MobileTarget;

/**
 * Description of SpaceJoinNotificationCategory
 *
 * @author buddha
 */
class FriendshipNotificationCategory extends NotificationCategory
{

    /**
     * Category Id
     * @var string 
     */
    public $id = 'friendship';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('FriendshipModule.notification', 'Friendship');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('FriendshipModule.notification', 'Receive Notifications for Friendship Request and Approval events.');
    }

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target->id === MailTarget::getId()) {
            return true;
        } elseif ($target->id === WebTarget::getId()) {
            return true;
        } elseif ($target->id === MobileTarget::getId()) {
            return true;
        }

        return $target->defaultSetting;
    }

    /**
     * @inheritdoc
     */
    public function isVisible(User $user = null)
    {
        return Yii::$app->getModule('friendship')->getIsEnabled();
    }

}
