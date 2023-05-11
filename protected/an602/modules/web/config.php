<?php

/** @noinspection MissedFieldInspection */

use an602\modules\web\Events;
use an602\modules\user\controllers\AuthController;
use an602\modules\web\Module;
use yii\web\Controller;

return [
    'id' => 'web',
    'class' => Module::class,
    'isCoreModule' => true,
    'urlManagerRules' => [
        'sw.js' => 'web/pwa-service-worker/index',
        'manifest.json' => 'web/pwa-manifest/index',
        'offline.pwa.html' => 'web/pwa-offline/index'
    ],
    'events' => [
        [Controller::class, Controller::EVENT_BEFORE_ACTION, [Events::class, 'onBeforeAction']],
        [AuthController::class, AuthController::EVENT_AFTER_LOGIN, [Events::class, 'onAfterLogin']],
    ]
];
