<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\notifications;

use Yii;
use yii\bootstrap\Html;
use an602\modules\notification\components\BaseNotification;

/**
 * If an user was invited to a workspace, this notification is fired.
 *
 * @since 0.5
 */
class Invite extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'space';

    /**
     * @inheritdoc
     */
    public $viewName = 'invite';

    /**
     * @inheritdoc
     */
    public $markAsSeenOnClick = false;

    /**
     *  @inheritdoc
     */
    public function category()
    {
        return new SpaceMemberNotificationCategory;
    }

    /**
     *  @inheritdoc
     */
    public function getSpace()
    {
        return $this->source;
    }

    /**
     *  @inheritdoc
     */
    public function getUrl()
    {
        return $this->source->createUrl('/space/space/about');
    }

    /**
     *  @inheritdoc
     */
    public function getMailSubject()
    {
        return $this->getInfoText($this->originator->displayName, $this->getSpace()->displayName);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return $this->getInfoText(Html::tag('strong',
            Html::encode($this->originator->displayName)), Html::tag('strong',
            Html::encode($this->getSpace()->displayName)));

    }

    private function getInfoText($displayName, $spaceName)
    {
        return Yii::t('SpaceModule.notification', '{displayName} invited you to the space {spaceName}', [
            '{displayName}' => $displayName,
            '{spaceName}' => $spaceName
        ]);

    }
}
