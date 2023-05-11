<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\web;

use an602\modules\web\pwa\controllers\ManifestController;
use an602\modules\web\pwa\controllers\OfflineController;
use an602\modules\web\pwa\controllers\ServiceWorkerController;
use Yii;
use an602\controllers\ErrorController;
use an602\models\Setting;
use an602\modules\web\security\helpers\Security;

/**
 * Event Handling Callbacks
 *
 * @package an602\modules\web
 */
class Events
{
    public static function onBeforeAction($evt)
    {
        if(Yii::$app->request->isConsoleRequest) {
            return;
        }

        Security::applyHeader(static::generateCSPRequestCheck());
    }

    /**
     * @return bool whether or not to generate a csp header for the current request
     */
    private static function generateCSPRequestCheck()
    {
        return !Yii::$app->request->isAjax
            && Setting::isInstalled()
            && !(Yii::$app->controller instanceof ErrorController)
            && !(Yii::$app->controller instanceof OfflineController)
            && !(Yii::$app->controller instanceof ManifestController)
            && !(Yii::$app->controller instanceof ServiceWorkerController);
    }

    public static function onAfterLogin($evt)
    {
        // Make sure a new nonce is generated after login
        Security::setNonce(null);
    }
}
