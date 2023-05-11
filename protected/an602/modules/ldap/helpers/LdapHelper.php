<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ldap\helpers;

use an602\modules\ldap\authclient\LdapAuth;
use Yii;

/**
 * This class contains LDAP helpers
 *
 * @since 0.5
 */
class LdapHelper
{

    /**
     * Checks if LDAP is supported by this environment.
     *
     * @return bool
     */
    public static function isLdapAvailable()
    {
        if (!class_exists('Laminas\Ldap\Ldap')) {
            return false;
        }

        if (!function_exists('ldap_bind')) {
            return false;
        }

        return true;
    }

    /**
     * Checks if at least one LDAP Authclient is enabled.
     *
     * @return bool
     */
    public static function isLdapEnabled()
    {
        foreach (Yii::$app->authClientCollection->getClients() as $authClient) {
            if ($authClient instanceof LdapAuth) {
                return true;
            }
        }

        return false;

    }

}
