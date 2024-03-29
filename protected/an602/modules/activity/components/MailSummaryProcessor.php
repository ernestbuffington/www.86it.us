<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\components;

use an602\modules\activity\Module;
use Yii;
use yii\helpers\Console;
use an602\modules\activity\components\MailSummary;
use an602\modules\user\models\User;

/**
 * MailSummaryProcessor is called by cron on given intervals (daily or hourly)
 * and creates mail summaries from the users.
 *
 * @since 1.2
 * @author Luke
 */
class MailSummaryProcessor
{

    /**
     * Processes mail summary for given interval
     *
     * @param int $interval
     */
    public static function process($interval)
    {
        $users = User::find()->distinct()->joinWith(['httpSessions', 'profile'])->active();

        $interactive = false;
        $totalUsers = $users->count();
        $processed = 0;
        $mailsSent = 0;

        if ($interval == MailSummary::INTERVAL_DAILY) {
            if ($interactive) {
                Console::startProgress($processed, $totalUsers, 'Sending daily e-mail summary to users... ', false);
            }
        } elseif ($interval === MailSummary::INTERVAL_HOURLY) {
            if ($interactive) {
                Console::startProgress($processed, $totalUsers, 'Sending hourly e-mail summary to users... ', false);
            }
        } elseif ($interval === MailSummary::INTERVAL_WEEKLY) {
            if ($interactive) {
                Console::startProgress($processed, $totalUsers, 'Sending weekly e-mail summary to users... ', false);
            }
        } else {
            return;
        }

        foreach ($users->each() as $user) {

            // Check if user wants summary in the given interval
            try {
                if (self::checkUser($user, $interval)) {
                    $mailSummary = Yii::createObject([
                                'class' => MailSummary::class,
                                'user' => $user,
                                'interval' => $interval
                    ]);
                    if ($mailSummary->send()) {
                        $mailsSent++;
                    }
                }
            } catch (\Exception $ex) {
                Yii::error('Could not send activity mail to: ' . $user->displayName . ' (' . $ex->getMessage() . ')', 'activity');
            }

            // Remove cached user settings
            Yii::$app->getModule('activity')->settings->flushContentContainer($user);

            if ($interactive) {
                Console::updateProgress( ++$processed, $totalUsers);
            }

        }

        if ($interactive) {
            Console::endProgress(true);
            Yii::$app->controller->stdout('done - ' . $mailsSent . ' email(s) sent.' . PHP_EOL, Console::FG_GREEN);
        }
    }

    /**
     * Checks if a e-mail summary should be send to the user
     *
     * @param User $user
     * @param int $interval
     * @return bool
     */
    protected static function checkUser(User $user, $interval)
    {
        if (empty($user->email)) {
            return false;
        }

        /* @var $activityModule Module */
        $activityModule = Yii::$app->getModule('activity');
        $defaultInterval = (int) $activityModule->settings->get('mailSummaryInterval', MailSummary::INTERVAL_DAILY);
        $wantedInterval = (int) $activityModule->settings->user($user)->get('mailSummaryInterval', $defaultInterval);

        return $interval === $wantedInterval;
    }

}
