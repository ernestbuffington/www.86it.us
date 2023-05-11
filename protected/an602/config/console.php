<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'id' => 'an602-console',
    'controllerNamespace' => 'an602\commands',
    'components' => [
        'user' => [
            'class' => \an602\modules\user\components\User::class,
            'identityClass' => \an602\modules\user\models\User::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => ['/user/auth/login']
        ],
    ],
];
