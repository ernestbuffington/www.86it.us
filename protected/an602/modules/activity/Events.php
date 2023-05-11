<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity;

use an602\components\ActiveRecord;
use an602\modules\activity\components\MailSummary;
use an602\modules\activity\helpers\ActivityHelper;
use an602\modules\activity\jobs\SendMailSummary;
use an602\modules\activity\models\Activity;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\widgets\SettingsMenu;
use an602\modules\ui\menu\MenuLink;
use an602\modules\user\widgets\AccountMenu;
use Yii;
use yii\base\ActionEvent;
use yii\base\BaseObject;
use yii\base\Event;
use yii\base\InvalidArgumentException;
use yii\db\IntegrityException;

/**
 * Events provides callbacks to handle events.
 *
 * @author luke
 */
class Events extends BaseObject
{

    /**
     * Handles cron hourly run event to send mail summaries to the users
     *
     * @param ActionEvent $event
     */
    public static function onCronHourlyRun($event)
    {
        if (static::getModule()->enableMailSummaries) {
            Yii::$app->queue->push(new SendMailSummary(['interval' => MailSummary::INTERVAL_HOURLY]));
        }
    }

    /**
     * Handles cron daily run event to send mail summaries to the users
     *
     * @param ActionEvent $event
     */
    public static function onCronDailyRun($event)
    {
        $module = static::getModule();
        if ($module->enableMailSummaries) {
            Yii::$app->queue->push(new SendMailSummary(['interval' => MailSummary::INTERVAL_DAILY]));
            if (date('w') == $module->weeklySummaryDay) {
                Yii::$app->queue->push(new SendMailSummary(['interval' => MailSummary::INTERVAL_WEEKLY]));
            }
        }
    }

    /**
     * On delete of some active record, check if there are related activities and delete them.
     *
     * @param Event $event
     */
    public static function onActiveRecordDelete(Event $event)
    {
        if (!($event->sender instanceof ActiveRecord)) {
            throw new InvalidArgumentException('The handler can be applied only to the \an602\components\ActiveRecord.');
        }

        ActivityHelper::deleteActivitiesForRecord($event->sender);
    }

    public static function onAccountMenuInit($event)
    {
        if (static::getModule()->enableMailSummaries) {
            /** @var AccountMenu $menu */
            $menu = $event->sender;

            $menu->addEntry(new MenuLink([
                'label' => Yii::t('ActivityModule.base', 'E-Mail Summaries'),
                'id' => 'account-settings-emailsummary',
                'icon' => 'envelope',
                'url' => ['/activity/user'],
                'sortOrder' => 105,
                'isActive' => MenuLink::isActiveState('activity')
            ]));
        }
    }


    public static function onSettingsMenuInit($event)
    {
        if (static::getModule()->enableMailSummaries) {
            /** @var SettingsMenu $menu */
            $menu = $event->sender;

            $menu->addEntry(new MenuLink([
                'label' => Yii::t('ActivityModule.base', 'E-Mail Summaries'),
                'url' => ['/activity/admin/defaults'],
                'sortOrder' => 300,
                'isActive' => MenuLink::isActiveState('activity', 'admin', 'defaults'),
                'isVisible' => Yii::$app->user->can(ManageSettings::class)
            ]));
        }
    }

    /**
     * Callback to validate module database records.
     *
     * @param Event $event
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function onIntegrityCheck($event)
    {
        $integrityController = $event->sender;
        $integrityController->showTestHeadline('Activity Module (' . Activity::find()->count() . ' entries)');

        // Loop over all comments
        foreach (Activity::find()->each() as $a) {
            /** @var Activity $a */

            // Check for object_model / object_id
            if ($a->object_model != '' && $a->object_id != '') {
                try {
                    $source = $a->getSource();
                } catch (IntegrityException $ex) {
                    if ($integrityController->showFix('Deleting activity id ' . $a->id . ' without existing target! (' . $a->object_model . ')')) {
                        $a->hardDelete();
                    }
                }
            }

            // Check for moduleId is set
            if (empty($a->module) && $integrityController->showFix('Deleting activity id ' . $a->id . ' without module_id!')) {
                $a->hardDelete();
            }

            // Check Activity class exists
            if (!class_exists($a->class) && $integrityController->showFix('Deleting activity id ' . $a->id . ' class not exists! (' . $a->class . ')')) {
                $a->hardDelete();
            }
        }
    }


    /**
     * @return Module
     */
    private static function getModule()
    {
        return Yii::$app->getModule('activity');
    }

}
