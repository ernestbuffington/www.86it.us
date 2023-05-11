<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\controllers;

use an602\components\access\ControllerAccess;
use an602\components\Controller;
use an602\modules\notification\models\Notification;
use Yii;
use yii\db\IntegrityException;

/**
 * ListController
 *
 * @since 0.5
 */
class ListController extends Controller
{
    /**
     * @inheritDoc
     */
    public function getAccessRules()
    {
        return [
            [ControllerAccess::RULE_LOGGED_IN_ONLY]
        ];
    }

    /**
     * Returns a List of all notifications for an user
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $notifications = Notification::loadMore(Yii::$app->request->get('from', 0));
        $lastEntryId = 0;

        $output = "";
        foreach ($notifications as $notification) {
            try {
                $baseModel = $notification->getBaseModel();

                if (!$baseModel || !$baseModel->validate()) {
                    throw new IntegrityException('Invalid base model found for notification');
                }

                $output .= $baseModel->render();
                $lastEntryId = $notification->id;
                $notification->desktop_notified = 1;
                $notification->update();
            } catch (IntegrityException $ie) {
                $notification->delete();
                Yii::warning('Deleted inconsistent notification with id ' . $notification->id . '. ' . $ie->getMessage());
            } catch (\Exception $e) {
                Yii::error('Could not display notification: ' . $notification->id . '(' . $e . ')');
            }
        }

        $this->asJson([
            'newNotifications' => Notification::findUnseen()->count(),
            'lastEntryId' => $lastEntryId,
            'output' => $output,
            'counter' => count($notifications)
        ]);
    }

    /**
     * Marks all notifications as seen
     * @throws \yii\web\HttpException
     */
    public function actionMarkAsSeen()
    {
        $this->forcePostRequest();

        $count = Notification::updateAll(['seen' => 1], ['user_id' => Yii::$app->user->id]);

        return $this->asJson( [
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Returns new notifications
     *
     * @deprecated since version 1.2
     */
    public function actionGetUpdateJson()
    {
        return $this->asJson(self::getUpdates());
    }

    /**
     * Returns a JSON which contains
     * - Number of new / unread notification
     * - Notification Output for new HTML5 Notifications
     *
     * @param bool $includeContent weather or not to include the actual notification content
     * @return string JSON String
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function getUpdates($includeContent = true)
    {
        $update['newNotifications'] = Notification::findUnseen()->count();

        $unnotified = Notification::findUnnotifiedInFrontend()->all();

        $update['notifications'] = [];
        foreach ($unnotified as $notification) {

            if ($includeContent && Yii::$app->getModule('notification')->settings->user()->getInherit('enable_html5_desktop_notifications', true)) {
                try {
                    $baseModel = $notification->getBaseModel();

                    if($baseModel->validate()) {
                        $update['notifications'][] = $baseModel;
                    } else {
                        throw new IntegrityException('Invalid base model found for notification');
                    }
                } catch (IntegrityException $ex) {
                    $notification->delete();
                    Yii::warning('Deleted inconsistent notification with id ' . $notification->id . '. ' . $ex->getMessage());
                    continue;
                }
            }
            $notification->desktop_notified = 1;
            $notification->update();
        }

        return $update;
    }

}
