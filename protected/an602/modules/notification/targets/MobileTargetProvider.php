<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 01.10.2017
 * Time: 15:15
 */

namespace an602\modules\notification\targets;


use an602\modules\notification\components\BaseNotification;
use an602\modules\user\models\User;

interface MobileTargetProvider
{
    /**
     * @param BaseNotification $notification
     * @param User $user
     * @return boolean
     */
    public function handle(BaseNotification $notification, User $user);

    /**
     * @param User|null $user
     * @return boolean
     */
    public function isActive(User $user = null);
}
