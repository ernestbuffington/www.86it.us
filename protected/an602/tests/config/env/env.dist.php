<?php

/**
 * Rename this file to env.php and change your db username and password.
 * When running custom module tests you may need to set the 'moduleAutoloadPaths' parameter unless all your custom modules reside in
 * '@an602/protected/modules'
 */

return [
    'components' => [
        'db' => [
            'username' => 'your_testDB_user',
            'password' => 'your_testDB_password',
        ],
    ],
    'params' => [
        'moduleAutoloadPaths' => [/* Insert module autoloader path of your test environment e.g. 'D:\development\an602\modules' */]
    ]
];
