<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\commands\CronController;
use an602\components\ModuleManager;
use an602\modules\admin\widgets\ModuleControls;
use an602\modules\admin\widgets\ModuleFilters;
use an602\modules\admin\widgets\Modules;
use an602\modules\marketplace\Events;
use an602\modules\marketplace\Module;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'marketplace',
    'class' => Module::class,
    'isCoreModule' => true,
    'consoleControllerMap' => [
        'module' => 'an602\modules\marketplace\commands\MarketplaceController',
        'professional-edition' => 'an602\modules\marketplace\commands\ProfessionalEditionController'
    ],
    'events' => [
        [CronController::class, CronController::EVENT_ON_HOURLY_RUN, [Events::class, 'onHourlyCron']],
        [ModuleFilters::class, ModuleFilters::EVENT_INIT, [Events::class, 'onAdminModuleFiltersInit']],
        [ModuleFilters::class, ModuleFilters::EVENT_AFTER_RUN, [Events::class, 'onAdminModuleFiltersAfterRun']],
        [Modules::class, Modules::EVENT_INIT, [Events::class, 'onAdminModulesInit']],
        [ModuleManager::class, ModuleManager::EVENT_AFTER_FILTER_MODULES, [Events::class, 'onAdminModuleManagerAfterFilterModules']],
        [ModuleControls::class, ModuleControls::EVENT_INIT, [Events::class, 'onAdminModuleControlsInit']],
    ]
];
