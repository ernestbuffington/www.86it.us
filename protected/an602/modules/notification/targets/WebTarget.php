<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\targets;

use Yii;
use yii\base\Exception;
use an602\modules\user\models\User;
use an602\modules\notification\components\BaseNotification;
use an602\modules\notification\live\NewNotification;

/**
 * Web Target
 * 
 * @since 1.2
 * @author buddha
 */
class WebTarget extends BaseTarget
{

    /**
     * @inheritdoc
     */
    public $id = 'web';

    /**
     * @inheritdoc
     */
    public $defaultSetting = true;

    /**
     * Handles Webnotifications by setting the send_web_notifications flag and sending an live event.
     */
    public function handle(BaseNotification $notification, User $user)
    {
        if (!$notification->record) {
            throw new Exception('Notification record not found for BaseNotification "' . $notification->className() . '"');
        }

        $notification->record->send_web_notifications = true;
        $notification->record->save();

        Yii::$app->live->send(new NewNotification([
            'notificationId' => $notification->record->id,
            'notificationGroup' => ($notification->getGroupKey()) ? (get_class($notification).':'.$notification->getGroupKey()) : null,
            'contentContainerId' => $user->contentcontainer_id,
            'ts' => time(),
            'text' => $notification->text()
        ]));
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('NotificationModule.targets', 'Web');
    }

}
