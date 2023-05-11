<?php

namespace an602\modules\notification\tests\codeception\unit\category\notifications;

/**
 * Description of TestedDefaultViewNotification
 *
 * @author buddha
 */
class SpecialNotification extends \an602\modules\notification\components\BaseNotification
{
    
    /**
     * @inheritdoc
     */
    public function category()
    {
        return new SpecialNotificationCategory();
    }
}
