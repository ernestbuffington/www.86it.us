<?php


/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\helpers;


use an602\modules\user\models\User;
use an602\modules\user\Module;
use Yii;

/**
 * Class AuthHelper
 *
 * @since 1.4
 * @package an602\modules\user\helpers
 */
class AuthHelper
{

    /**
     * Checks if limited access is allowed for unauthenticated users.
     *
     * @return boolean
     */
    public static function isGuestAccessEnabled()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('user');

        if ($module->settings->get('auth.allowGuestAccess')) {
            return true;
        }

        return false;
    }

    /**
     * Find or generates a username based on given attributes provided
     * by an AuthClient.
     *
     * @param $attributes
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generateUsernameByAttributes($attributes): string
    {
        if (isset($attributes['username'])) {
            $user = User::find()->where(['username' => $attributes['username']]);
            if (!$user->exists()) {
                return $attributes['username'];
            }
        }

        $username = [];
        if (isset($attributes['firstname']) && !empty($attributes['firstname'])) {
            $username[] = $attributes['firstname'];
        }
        if (isset($attributes['lastname']) && !empty($attributes['lastname'])) {
            $username[] = $attributes['lastname'];
        } elseif (isset($attributes['family_name']) && !empty($attributes['family_name'])) {
            $username[] = $attributes['family_name'];
        }

        if (empty($username)) {
            $username = Yii::$app->security->generateRandomString(8);
        } else {
            $username = implode('_', $username);
        }

        if (empty($username) || $username === '_') {
            $username = explode("@", $attributes['email'])[0];
        }

        $username = strtolower(substr($username, 0, 32));
        $usernameRandomSuffix = '';
        $user = User::find()->where(['username' => $username . $usernameRandomSuffix]);

        while ($user->exists()) {
            $usernameRandomSuffix = '_' . strtolower(Yii::$app->security->generateRandomString(2));
            $user->where(['username' => $username . $usernameRandomSuffix]);
        }

        return $username . $usernameRandomSuffix;
    }
}
