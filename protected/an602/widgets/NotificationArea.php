<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

/**
 * NotificationAddonWidget is used to add items like Notification, Mail, Timer to the main layout
 *
 * @since 0.5
 * @author Luke
 */
class NotificationArea extends BaseStack
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->addNotificationOverview();
    }

    /**
     * Adds notification overview widget, if not already exists to provide
     * backward compatiblity.
     */
    protected function addNotificationOverview()
    {
        $found = false;
        $notificationOverviewClass = 'an602\modules\notification\widgets\Overview';
        foreach ($this->getWidgets() as $widget) {
            if ($widget[0] == $notificationOverviewClass) {
                $found = true;
            }
        }

        if (!$found) {
            $this->addWidget($notificationOverviewClass, [], ['sortOrder' => 10]);
        }
    }

}
