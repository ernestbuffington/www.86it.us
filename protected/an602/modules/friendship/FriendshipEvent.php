<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship;

use yii\base\Event;

/**
 * FriendshipEvent
 * 
 * @since 1.2
 * @author Luke
 */
class FriendshipEvent extends Event
{

    /**
     * @var \an602\modules\user\models\User first user
     */
    public $user1;

    /**
     * @var \an602\modules\user\models\User second user
     */
    public $user2;

}
