<?php

namespace an602\modules\notification\tests\codeception\unit\category\notifications;

/**
 * Description of TestedDefaultViewNotification
 *
 * @author buddha
 */
class TestNotification extends \an602\modules\notification\components\BaseNotification
{
    /**
     * @inheritdoc
     */
    public function category()
    {
        return new TestNotificationCategory();
    }
}
