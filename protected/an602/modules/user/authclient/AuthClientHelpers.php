<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\authclient;

use an602\modules\user\models\User;
use an602\modules\user\services\AuthClientUserService;
use yii\authclient\ClientInterface;

/**
 * @deprecated since 1.14
 */
class AuthClientHelpers
{
    /**
     * @deprecated since 1.14
     */
    public static function storeAuthClientForUser(ClientInterface $authClient, User $user)
    {
        (new AuthClientUserService($user))->add($authClient);
    }
}
