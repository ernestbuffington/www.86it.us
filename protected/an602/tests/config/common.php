<?php

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=an602_test',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'attributes' => [
                PDO::ATTR_PERSISTENT => true
            ]
        ],
        'view' => [
            'theme' =>
            [
                'name' => 'an602',
                'basePath' => '@webroot/themes/an602',
            ],
        ],
        'queue' => [
            'class' => 'an602\modules\queue\driver\Instant',
        ],
    ],
    'params' => [
        'installed' => true,
    ],
    'modules' => [
        'user' => [
            'loginRememberMeDefault' => false
        ],
        'web' => [
            'security' =>  [
                "headers" => [
                    "Strict-Transport-Security" => "max-age=31536000",
                    "X-XSS-Protection" => "1; mode=block",
                    "X-Content-Type-Options" => "nosniff",
                    "X-Frame-Options" => "deny",
                    "Referrer-Policy" => "no-referrer-when-downgrade",
                    "X-Permitted-Cross-Domain-Policies" => "master-only",
                    "My-Custom-Security-Header" => "test"
                ],
                "csp" => [
                    "nonce" => true,
                    "report-only" => false,
                    "report" => false,
                    "default-src" => [
                        "self" => true
                    ],
                    "img-src" => [
                        "allow" => [
                            "*"
                        ]
                    ],
                    "font-src" => [
                        "self" => true
                    ],
                    "style-src" => [
                        "self" => true,
                        "unsafe-inline" => true
                    ],
                    "object-src" => [
                        'self' => true
                    ],
                    "frame-src" => [
                        "allow" => [
                            "*"
                        ]
                    ],
                    "script-src" => [
                        "self" => true,
                        "unsafe-inline" => true,
                        "unsafe-eval" => false,
                        "report-sample" => true
                    ],
                    "upgrade-insecure-requests" => true
                ]
            ]
        ]
    ]
];
