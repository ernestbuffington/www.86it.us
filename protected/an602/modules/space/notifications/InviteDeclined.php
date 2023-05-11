<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\notifications;

use an602\modules\notification\components\BaseNotification;
use Yii;
use yii\bootstrap\Html;

/**
 * SpaceInviteDeclinedNotification is sent to the originator of the invite to
 * inform him about the decline.
 *
 * @since 0.5
 * @author Luke
 */
class InviteDeclined extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'space';

    /**
     * @inheritdoc
     */
    public $viewName = 'inviteDeclined';

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

    public function getMailSubject()
    {
        return $this->getInfoText($this->originator->displayName, $this->getSpace()->name);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return $this->getInfoText(
            Html::tag('strong', Html::encode($this->originator->displayName)),
            Html::tag('strong', Html::encode($this->getSpace()->name)));
    }

    private function getInfoText($displayName, $spaceName)
    {
        return Yii::t('SpaceModule.notification', '{displayName} declined your invite for the space {spaceName}', [
            '{displayName}' => $displayName,
            '{spaceName}' => $spaceName
        ]);
    }

}
