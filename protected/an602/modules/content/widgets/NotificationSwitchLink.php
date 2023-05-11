<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

/**
 * NotificationSwitch for Wall Entries
 *
 * This widget allows turn on/off of notifications of a content.
 *
 * @package an602.modules_core.wall.widgets
 * @since 0.10
 */
class NotificationSwitchLink extends \yii\base\Widget
{

    /**
     * @var \an602\modules\content\components\ContentActiveRecord
     */
    public $content;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return;
        }

        return $this->render('notificationSwitchLink', [
                    'content' => $this->content->content,
                    'state' => $this->content->isFollowedByUser(\Yii::$app->user->id, true)
        ]);
    }

}

?>