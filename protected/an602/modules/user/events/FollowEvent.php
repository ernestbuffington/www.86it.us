<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\events;

use yii\base\Event;

/**
 * FollowEvent
 *
 * @since 1.2
 * @author Luke
 */
class FollowEvent extends Event
{

    /**
     * @var \an602\modules\user\models\User
     */
    public $user;

    /**
     * @var \an602\components\ActiveRecord the followed item
     */
    public $target;

}
