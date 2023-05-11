<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\notifications;

use Yii;
use yii\bootstrap\Html;
use an602\modules\notification\components\BaseNotification;

/**
 * SpaceApprovalRequestAcceptedNotification
 *
 * @since 0.5
 */
class ApprovalRequestAccepted extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = "space";

    /**
     * @inheritdoc
     */
    public $viewName = "approvalAccepted";

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
        return Yii::t('SpaceModule.notification', '{displayName} approved your membership for the space {spaceName}', [
            '{displayName}' => $displayName,
            '{spaceName}' => $spaceName
        ]);
    }

}
