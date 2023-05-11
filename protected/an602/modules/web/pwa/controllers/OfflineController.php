<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\web\pwa\controllers;

use an602\components\access\ControllerAccess;
use an602\components\Controller;
use an602\modules\ui\Module;

/**
 * Class OfflineController is responsible to generate an offline page for PWAs.
 *
 * @since 1.4
 * @property Module $module
 * @package an602\modules\ui\controllers
 */
class OfflineController extends Controller
{
    /**
     * Allow guest access independently from guest mode setting.
     *
     * @var string
     */
    public $access = ControllerAccess::class;

    public function actionIndex()
    {
        return $this->renderPartial('@an602/modules/web/pwa/views/offline/index');
    }
}
