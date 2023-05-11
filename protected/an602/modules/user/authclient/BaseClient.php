<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\authclient;

use an602\modules\user\services\AuthClientService;

/**
 * Extended BaseClient with additional events
 *
 * @since 1.1
 * @author luke
 */
class BaseClient extends \yii\authclient\BaseClient
{

    /**
     * @event Event an event raised on update user data.
     * @see AuthClientService::updateUser()
     */
    const EVENT_UPDATE_USER = 'update';

    /**
     * @event Event an event raised on create user.
     * @see AuthClientService::createUser()
     */
    const EVENT_CREATE_USER = 'create';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {

    }

    /**
     * Workaround for serialization into session during the registration process
     *
     * @return void
     */
    public function beforeSerialize(): void
    {
    }
}
