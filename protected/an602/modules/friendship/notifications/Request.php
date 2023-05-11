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
 * Friends Request
 *
 * @since 1.1
 */
class Request extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = "friendship";

    /**
     * @inheritdoc
     */
    public $viewName = 'friendshipRequest';

    /**
     * @inheritdoc
     */
    public $markAsSeenOnClick = false;

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->originator->getUrl();
    }

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
        return Yii::t('FriendshipModule.notification', '{displayName} sent you a friend request.', [
            'displayName' => $displayName,
        ]);
    }

}
