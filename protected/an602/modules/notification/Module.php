<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification;

/**
 * Notification Module
 */
class Module extends \an602\components\Module
{
    /**
     * @var int Delete read notifications after 2 months(by default)
     */
    public $deleteSeenNotificationsMonths = 2;

    /**
     * @var int Delete unread notifications after 3 months(by default)
     */
    public $deleteUnseenNotificationsMonths = 3;
}
