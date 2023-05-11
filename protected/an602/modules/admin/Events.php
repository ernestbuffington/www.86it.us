<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin;

use an602\components\Application;
use an602\modules\admin\widgets\AdminMenu;
use an602\modules\user\events\UserEvent;
use Yii;

/**
 * Admin Module provides the administrative backend for an602 installations.
 *
 * @since 0.5
 */
class Events extends \yii\base\BaseObject
{

    /**
     * On Init of Dashboard Sidebar, add the approve notification widget
     *
     * @param \yii\base\Event $event the event
     */
    public static function onDashboardSidebarInit($event)
    {
        $event->sender->addWidget(widgets\MaintenanceModeWarning::class, [], ['sortOrder' => 0]);

        if (Yii::$app->user->isGuest) {
            return;
        }

        if (Yii::$app->getModule('user')->settings->get('auth.needApproval')) {
            if (Yii::$app->user->getIdentity()->canApproveUsers()) {
                $event->sender->addWidget(widgets\DashboardApproval::class, [], [
                    'sortOrder' => 99
                ]);
            }
        }

        $event->sender->addWidget(widgets\IncompleteSetupWarning::class, [], ['sortOrder' => 1]);
    }

    /**
     * Callback on daily cron job run
     *
     * @param \yii\base\Event $event
     */
    public static function onCronDailyRun($event)
    {
        Yii::$app->queue->push(new jobs\CleanupLog());
        Yii::$app->queue->push(new jobs\CleanupPendingRegistrations());
        Yii::$app->queue->push(new jobs\CheckForNewVersion());
    }

    /**
     * @param $event UserEvent
     */
    public static function onSwitchUser($event) {
        if(Yii::$app instanceof Application) {
            AdminMenu::reset();
        }
    }
}
