<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\controllers;

use an602\modules\admin\components\Controller;
use an602\modules\admin\libs\an602API;
use an602\modules\admin\permissions\ManageModules;
use an602\modules\marketplace\Module;
use Yii;

/**
 * Class PurchaseController
 *
 * @property Module $module
 * @package an602\modules\marketplace\controllers
 */
class PurchaseController extends Controller
{

    /**
     * @var string
     */
    public $defaultAction = 'list';

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => ManageModules::class]
        ];
    }

    /**
     * Complete list of all modules
     */
    public function actionList()
    {
        $hasError = false;
        $message = '';

        $licenceKey = Yii::$app->request->post('licenceKey', '');

        if ($licenceKey !== '') {
            $result = an602API::request('v1/modules/registerPaid', ['licenceKey' => $licenceKey]);
            if (!isset($result['status'])) {
                $hasError = true;
                $message = 'Could not connect to an602 API!';
            } elseif ($result['status'] == 'ok' || $result['status'] == 'created') {
                $message = 'Module licence added!';
                $licenceKey = '';
            } else {
                $hasError = true;
                $message = 'Invalid module licence key!';
            }
        }

        // Only showed purchased modules
        $onlineModules = $this->module->onlineModuleManager;
        $modules = $onlineModules->getModules(false);

        foreach ($modules as $i => $module) {
            if (!isset($module['purchased']) || !$module['purchased']) {
                unset($modules[$i]);
            }
        }

        return $this->renderAjax('list', [
            'modules' => $modules,
            'licenceKey' => $licenceKey,
            'hasError' => $hasError,
            'message' => $message,
        ]);
    }

}
