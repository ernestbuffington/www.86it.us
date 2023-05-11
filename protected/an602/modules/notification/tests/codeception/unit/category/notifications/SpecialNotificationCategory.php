<?php

namespace an602\modules\notification\tests\codeception\unit\category\notifications;

use an602\modules\user\models\User;
use an602\modules\notification\targets\BaseTarget;
use an602\modules\notification\targets\WebTarget;
use an602\modules\notification\targets\MailTarget;

/**
 * Description of TestedDefaultViewNotification
 *
 * @author buddha
 */
class SpecialNotificationCategory extends \an602\modules\notification\components\NotificationCategory
{

    public $id = 'test_special';

    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target->id === MailTarget::getId()) {
            return false;
        } elseif ($target->id === WebTarget::getId()) {
            return false;
        }

        return $target->defaultSetting;
    }

    public function getFixedSettings()
    {
        return [MailTarget::getId()];
    }

    public function isVisible(User $user = null)
    {
        return !$user || $user->id != 2;
    }

    public function getDescription()
    {
        return 'My Special Test Notification Category';
    }

    public function getTitle()
    {
        return 'Test Special Category';
    }

}
