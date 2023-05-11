<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\widgets;

use Yii;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\TabMenu;
use an602\modules\friendship\models\Friendship;

/**
 * Account Settings Tab Menu
 */
class ManageMenu extends TabMenu
{

    /**
     * @var \an602\modules\user\models\User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $friendCount = Friendship::getFriendsQuery($this->user)->count();

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FriendshipModule.base', 'Friends') . ' (' . $friendCount . ')',
            'url' => ['/friendship/manage/list'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState(null, 'manage', 'list')
        ]));

        $receivedRequestsCount = Friendship::getReceivedRequestsQuery($this->user)->count();
        $this->addEntry(new MenuLink([
            'label' => Yii::t('FriendshipModule.base', 'Requests') . ' (' . $receivedRequestsCount . ')',
            'url' => ['/friendship/manage/requests'],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState(null, 'manage', 'requests')
        ]));

        $sentRequestsCount = Friendship::getSentRequestsQuery($this->user)->count();
        $this->addEntry(new MenuLink([
            'label' => Yii::t('FriendshipModule.base', 'Sent requests') . ' (' . $sentRequestsCount . ')',
            'url' => ['/friendship/manage/sent-requests'],
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState(null, 'manage', 'sent-requests')
        ]));

        parent::init();
    }

}
