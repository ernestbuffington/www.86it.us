<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\dashboard;

use an602\modules\ui\menu\MenuLink;
use an602\widgets\TopMenu;
use Yii;
use yii\base\Event;

/**
 * Description of Events
 *
 * @author luke
 */
class Events
{

    /**
     * TopMenu init event callback
     *
     * @see TopMenu
     * @param Event $event
     */
    public static function onTopMenuInit($event)
    {
        /** @var TopMenu $topMenu */
        $topMenu = $event->sender;

        $topMenu->addEntry(new MenuLink([
            'id' => 'dashboard',
            'label' => Yii::t('DashboardModule.base', 'Dashboard'),
            'url' => ['/dashboard/dashboard'],
            'icon' => 'dashboard',
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('dashboard')
        ]));
    }

}
