<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\notifications;

use Yii;
use yii\bootstrap\Html;
use an602\modules\notification\components\BaseNotification;

/**
 * Declined Friends Request Notification
 *
 * @since 1.1
 */
class RequestDeclined extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = "friendship";

    /**
     * @inheritdoc
     */
    public $viewName = "friendshipDeclined";

    /**
    * @inheritdoc
    */
    public $requireSource = false;

    /**
     * @inheritdoc
     */
    public $markAsSeenOnClick = true;

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new FriendshipNotificationCategory;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->originator->getUrl();
    }

    public function getMailSubject()
    {
        return $this->getInfoText($this->originator->displayName);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return $this->getInfoText(Html::tag('strong', Html::encode($this->originator->displayName)));
    }

    private function getInfoText($displayName)
    {
        return Yii::t('FriendshipModule.notification', '{displayName} declined your friend request.', [
            'displayName' => $displayName,
        ]);
    }

}

?>
