<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification;

use an602\components\Event;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;
use Yii;
use an602\modules\notification\models\Notification;

/**
 * Events provides callbacks for all defined module events.
 *
 * @author luke
 */
class Events extends \yii\base\BaseObject
{

    /**
     * On User delete, also delete all posts
     *
     * @param Event $event
     */
    public static function onUserDelete($event)
    {
        /** @var User $user */
        $user = $event->sender;

        foreach (Notification::findAll(['user_id' => $user->id]) as $notification) {
            $notification->delete();
        }

        foreach (Notification::findAll(['originator_user_id' => $user->id]) as $notification) {
            $notification->delete();
        }

        foreach (Notification::findAll(['source_class' => User::class, 'source_pk' => $user->id]) as $notification) {
            $notification->delete();
        }

        return true;
    }

    /**
     * On workspace deletion make sure to delete all posts
     *
     * @param type $event
     */
    public static function onSpaceDelete($event)
    {

        foreach (Notification::findAll(['space_id' => $event->sender->id]) as $notification) {
            $notification->delete();
        }
    }

    /**
     * Callback to validate module database records.
     *
     * @param Event $event
     */
    public static function onIntegrityCheck($event)
    {

        $integrityChecker = $event->sender;
        $integrityChecker->showTestHeadline("Notification Module (" . Notification::find()->count() . " entries)");

        foreach (Notification::find()->joinWith(['user'])->each() as $notification) {
            /** @var Notification $notification */

            // Check if Space still exists
            if (!empty($notification->space_id)) {
                $space = Space::findOne(['id' => $notification->space_id]);
                if ($space === null) {
                    if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " workspace seems to no longer exist!")) {
                        $notification->delete();
                    }
                }
            }

            // Check if source object exists when defined
            try {
                if ($notification->source_class != "" && $notification->getSourceObject() == null) {
                    if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " source class set but seems to no longer exist!")) {
                        $notification->delete();
                    }
                }
            } catch (\Exception $e) {
                // Handles errors for getSourceObject() calls
                if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " source class set but seems to no longer exist!")) {
                    $notification->delete();
                }
            }

            // Check if target user exists
            if ($notification->user == null) {
                if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " target user seems to no longer exist!")) {
                    $notification->delete();
                }
            }

            // Check if target user exists
            if (!class_exists($notification->class)) {
                if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " without valid class!")) {
                    $notification->delete();
                }
            }

            // Check if module id is set
            if ($notification->module == "") {
                if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " without valid module!")) {
                    $notification->delete();
                }
            }

            if (!empty($notification->originator_user_id) && $notification->originator === null) {
                if ($integrityChecker->showFix("Deleting notification id " . $notification->id . " without valid originator!")) {
                    $notification->delete();
                }
            }


        }
    }

    /**
     * On run of the cron, do some cleanup stuff.
     * We delete all notifications which are older than 2 month and are seen.
     *
     * @param Event $event
     */
    public static function onCronDailyRun($event)
    {
        /* @var Module $module */
        $module = Yii::$app->getModule('notification');

        $controller = $event->sender;

        $controller->stdout('Deleting old notifications... ');

        // Delete seen notifications which are older than 2 months
        self::deleteNotifications(true, $module->deleteSeenNotificationsMonths);

        // Delete unseen notifications which are older than 3 months
        self::deleteNotifications(false, $module->deleteUnseenNotificationsMonths);

        $controller->stdout('done.' . PHP_EOL, \yii\helpers\Console::FG_GREEN);
    }

    /**
     * Delete notifications after X months
     *
     * @param bool $seen
     * @param int $months
     * @return int Number of deleted notifications
     */
    private static function deleteNotifications(bool $seen, int $months): int
    {
        return Notification::deleteAll(['AND',
            ['seen' => (int)$seen],
            ['<', 'created_at', date('Y-m-d', mktime(0, 0, 0, date('m') - $months))],
        ]);
    }

    public static function onActiveRecordDelete($event)
    {
        models\Notification::deleteAll([
            'source_class' => $event->sender->className(),
            'source_pk' => $event->sender->getPrimaryKey(),
        ]);
    }

    public static function onLayoutAddons($event)
    {
        if (Yii::$app->request->isPjax) {
            $event->sender->addWidget(widgets\UpdateNotificationCount::class);
        }
    }

}
