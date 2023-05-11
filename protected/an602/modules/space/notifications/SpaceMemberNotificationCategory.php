<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\notifications;

use an602\modules\notification\components\NotificationCategory;
use an602\modules\notification\targets\BaseTarget;
use an602\modules\notification\targets\MailTarget;
use an602\modules\notification\targets\MobileTarget;
use an602\modules\notification\targets\WebTarget;
use Yii;

/**
 * SpaceMemberNotificationCategory
 *
 * @author buddha
 */
class SpaceMemberNotificationCategory extends NotificationCategory
{
    /**
     * @inheritdoc
     */
    public $id = 'space_member';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t(
            'SpaceModule.notification',
            'Space Membership'
        );
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t(
            'SpaceModule.notification',
            'Receive Notifications of Space Membership events.'
        );
    }

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(BaseTarget $target)
    {
        switch ($target->id) {
            case MailTarget::getId():
            case WebTarget::getId():
            case MobileTarget::getId():
                return true;
            default:
                return $target->defaultSetting;
        }
    }

    /**
     * @inheritdoc
     */
    public function getFixedSettings()
    {
        $webTarget = Yii::createObject(WebTarget::class);
        return [
            $webTarget->id,
        ];
    }
}
