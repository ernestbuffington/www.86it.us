<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\web;

use Yii;
use an602\modules\web\security\controllers\ReportController;
use an602\modules\web\pwa\controllers\ManifestController;
use an602\modules\web\pwa\controllers\OfflineController;
use an602\modules\web\pwa\controllers\ServiceWorkerController;

/**
 * This module provides general web components.
 *
 * @since 1.4
 */
class Module extends \an602\components\Module
{
    /**
     * @inheritdoc
     */
    public $isCoreModule = true;

    /**
     * @var mixed web security settings
     */
    public $security;

    /**
     * @since 1.8
     * @var boolean Disable Service Worker and PWA Support
     */
    public $enableServiceWorker = true;

    /**
     * @inheritdoc
     */
    public $controllerMap = [
        'pwa-manifest' => ManifestController::class,
        'pwa-offline' => OfflineController::class,
        'pwa-service-worker' => ServiceWorkerController::class,
        'security-report' => ReportController::class
    ];

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('WebModule.base', 'Web');
    }

}
