<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\fieldtype;

use an602\libs\Html;

/**
 * UserName is a virtual profile field
 * that displays the current user name of the user.
 *
 * @since 1.6
 */
class UserName extends BaseTypeVirtual
{

    /**
     * @inheritDoc
     */
    public function getVirtualUserValue($user, $raw = true)
    {
        if (empty($user->username)) {
            return '';
        }

        return Html::encode($user->username);
    }
}
