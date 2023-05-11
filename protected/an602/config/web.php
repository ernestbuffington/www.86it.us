<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

$config = [
    'id' => 'an602',
    'bootstrap' => ['an602\components\bootstrap\LanguageSelector'],
    'defaultRoute' => '/home',
    'layoutPath' => '@an602/views/layouts',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@npm/jquery/dist',
                ],
            ],
        ],
        'request' => [
            'class' => \an602\components\Request::class,
            'csrfCookie' => [
                'sameSite' => PHP_VERSION_ID >= 70300 ? yii\web\Cookie::SAME_SITE_LAX : null,
            ],
        ],
        'response' => [
            'class' => \an602\components\Response::class,
        ],
        'user' => [
            'class' => \an602\modules\user\components\User::class,
            'identityClass' => \an602\modules\user\models\User::class,
            'enableAutoLogin' => true,
            'authTimeout' => 1400,
            'loginUrl' => ['/user/auth/login'],
            'identityCookie' => [
                'name' => '_identity',
                'sameSite' => PHP_VERSION_ID >= 70300 ? yii\web\Cookie::SAME_SITE_LAX : null,
            ],
        ],
        'errorHandler' => [
            'errorAction' => '/error/index',
        ],
        'session' => [
            'class' => \an602\modules\user\components\Session::class,
            'cookieParams' => [
                'httpOnly' => true,
                'sameSite' => PHP_VERSION_ID >= 70300 ? yii\web\Cookie::SAME_SITE_LAX : null,
            ],
        ],
    ],
    'modules' => [
        'web' => [
            'security' => [
                "headers" => [
                    "Strict-Transport-Security" => "max-age=31536000",
                    "X-XSS-Protection" => "1; mode=block",
                    "X-Content-Type-Options" => "nosniff",
                    "Referrer-Policy" => "no-referrer-when-downgrade",
                    "X-Permitted-Cross-Domain-Policies" => "master-only",
                    "X-Frame-Options" => "sameorigin",
                    "Content-Security-Policy" => "default-src *; connect-src  *; font-src 'self'; frame-src https://* http://* *; img-src https://* http://* * data:; object-src 'self'; script-src 'self' https://* http://* * 'unsafe-inline' 'report-sample'; style-src * https://* http://* * 'unsafe-inline';"
                ]
            ]
        ]
    ],
    'container' => [
        'definitions' => [
            'yii\web\Cookie' => ['\an602\libs\CookieBuilder', 'build'],
        ]
    ]
];

return $config;
