<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship;

use Yii;
use yii\helpers\Url;

/**
 * Events provides callbacks for all defined module events.
 * 
 * @author luke
 */
class Events extends \yii\base\BaseObject
{

    /**
     * Add friends navigation entry to account menu
     * 
     * @param \yii\base\Event $event
     */
    public static function onAccountMenuInit($event)
    {
        if (Yii::$app->getModule('friendship')->getIsEnabled()) {
            $event->sender->addItem([
                'label' => Yii::t('FriendshipModule.base', 'Friends'),
                'url' => Url::to(['/friendship/manage']),
                'icon' => '<i class="fa fa-group"></i>',
                'group' => 'account',
                'sortOrder' => 130,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'friendship'),
            ]);
        }
    }

}
