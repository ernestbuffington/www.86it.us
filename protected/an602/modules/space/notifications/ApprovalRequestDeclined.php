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
 * SpaceApprovalRequestDeclinedNotification
 *
 * @since 0.5
 */
class ApprovalRequestDeclined extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'space';

    /**
     * @inheritdoc
     */
    public $viewName = 'approvalDeclined';

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
    public function getMailSubject()
    {
        return $this->getInfoText($this->originator->displayName, $this->source->name);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return $this->getInfoText(
            Html::tag('strong', Html::encode($this->originator->displayName)),
            Html::tag('strong', Html::encode($this->source->name)));
    }

    private function getInfoText($displayName, $spaceName)
    {
        return Yii::t('SpaceModule.notification', '{displayName} declined your membership request for the space {spaceName}', [
            '{displayName}' => $displayName,
            '{spaceName}' => $spaceName
        ]);
    }

}
