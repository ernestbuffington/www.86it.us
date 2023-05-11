<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\admin\widgets\AuthenticationMenu;
use an602\modules\ldap\Events;
use an602\modules\user\authclient\Collection;
use an602\components\console\Application;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'ldap',
    'class' => \an602\modules\ldap\Module::class,
    'isCoreModule' => true,
    'consoleControllerMap' => [
        'ldap' => 'an602\modules\ldap\commands\LdapController'
    ],
    'events' => [
        [AuthenticationMenu::class, AuthenticationMenu::EVENT_INIT, [Events::class, 'onAuthenticationMenu']],
        [Collection::class, Collection::EVENT_BEFORE_CLIENTS_SET, [Events::class, 'onAuthClientCollectionSet']],
    ]
];
?>
