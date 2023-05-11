<?php

namespace an602\modules\notification\tests\codeception\unit\category\notifications;

use an602\modules\notification\targets\MailTarget;
use an602\modules\notification\targets\WebTarget;
use an602\modules\notification\targets\BaseTarget;

/**
 * Description of TestedDefaultViewNotification
 *
 * @author buddha
 */
class TestNotificationCategory extends \an602\modules\notification\components\NotificationCategory
{

    public $id = 'test';

    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target->id === MailTarget::getId()) {
            return false;
        } elseif ($target->id === webTarget::getId()) {
            return true;
        }

        return $target->defaultSetting;
    }

    public function getDescription()
    {
        return 'My Test Notification Category';
    }

    public function getTitle()
    {
        return 'Test Category';
    }

}
