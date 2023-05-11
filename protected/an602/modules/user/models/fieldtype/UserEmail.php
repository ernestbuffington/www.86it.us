<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\fieldtype;

use an602\libs\Html;

/**
 * UserEmail is a virtual profile field
 * that displays the current email address of the user.
 *
 * @since 1.6
 */
class UserEmail extends BaseTypeVirtual
{

    /**
     * @inheritDoc
     */
    public function getVirtualUserValue($user, $raw = true)
    {
        if (empty($user->email)) {
            return '';
        }

        if ($raw) {
            return Html::encode($user->email);
        } else {
            return Html::a(Html::encode($user->email), 'mailto:' . $user->email);
        }
    }
}
