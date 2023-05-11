<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\fieldtype;

use an602\libs\Html;
use Yii;

/**
 * UserLastLogin is a virtual profile field
 * that displays the user last login dati
 *
 * @since 1.6
 */
class UserLastLogin extends BaseTypeVirtual
{

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function getVirtualUserValue($user, $raw = true)
    {
        if (empty($user->last_login)) {
            return '-';
        }

        return Yii::$app->formatter->asDate($user->last_login,'long');
    }
}
