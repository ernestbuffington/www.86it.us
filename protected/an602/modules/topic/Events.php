<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic;

use an602\modules\content\components\ContentActiveRecord;
use an602\modules\topic\models\Topic;
use an602\modules\topic\widgets\ContentTopicButton;
use an602\modules\topic\widgets\TopicPicker;
use an602\modules\ui\menu\MenuLink;
use an602\modules\user\events\UserEvent;
use an602\modules\user\widgets\AccountMenu;
use Yii;
use yii\base\BaseObject;

class Events extends BaseObject
{
    public static function onWallEntryControlsInit($event)
    {
        /** @var ContentActiveRecord $record */
        $record = $event->sender->object;

        if ($record->content->canEdit() && TopicPicker::showTopicPicker($record->content->container)) {
            $event->sender->addWidget(ContentTopicButton::class, ['record' => $record], ['sortOrder' => 370]);
        }
    }

    /**
     * @param $event
     */
    public static function onSpaceSettingMenuInit($event)
    {
        $space = $event->sender->space;

        if ($space->isAdmin()) {
            $event->sender->addItem([
                'label' => Yii::t('TopicModule.base', 'Topics'),
                'url' => $space->createUrl('/topic/manage'),
                'isActive' => MenuLink::isActiveState('topic', 'manage'),
                'sortOrder' => 250
            ]);
        }
    }

    /**
     * @param $event UserEvent
     */
    public static function onProfileSettingMenuInit($event)
    {
        if(Yii::$app->user->isGuest) {
            return;
        }

        $event->sender->addItem([
            'label' => Yii::t('TopicModule.base', 'Topics'),
            'url' => Yii::$app->user->identity->createUrl('/topic/manage'),
            'isActive' => MenuLink::isActiveState('topic', 'manage'),
            'sortOrder' => 250
        ]);

        if(MenuLink::isActiveState('topic', 'manage')) {
            AccountMenu::markAsActive('account-settings-settings');
        }
    }
}
