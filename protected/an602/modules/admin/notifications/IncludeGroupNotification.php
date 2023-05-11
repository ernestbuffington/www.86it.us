<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\notifications;

use an602\modules\notification\components\BaseNotification;
use an602\modules\user\models\Group;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * It occurs when a member from the group is included
 * @property Group $source
 * @since 1.3
 */
class IncludeGroupNotification extends BaseNotification
{
    /**
     * @inheritdoc
     */
    public $moduleId = 'admin';

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return Url::to(['/user/people']);
    }

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new AdminNotificationCategory;
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        return \Yii::t(
            'AdminModule.notification',
            'Notify from {appName}. You were added to the group.',
            ['appName' => \Yii::$app->name]
        );
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return \Yii::t(
            'AdminModule.notification',
            '{displayName} added you to group {groupName}',
            [
                '{displayName}' => Html::tag('strong', Html::encode($this->originator->getDisplayName())),
                '{groupName}' => Html::tag('strong', Html::encode($this->source->name)),
            ]
        );
    }
}
