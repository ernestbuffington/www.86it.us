<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\controllers;

use an602\modules\admin\components\Controller;
use an602\modules\admin\permissions\ManageModules;
use an602\modules\marketplace\Module;
use Yii;
use yii\web\HttpException;

/**
 * Class BrowseController
 *
 * @property Module $module
 * @package an602\modules\marketplace\controllers
 */
class BrowseController extends Controller
{
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
     * Returns the thirdparty disclaimer
     *
     * @throws HttpException
     */
    public function actionThirdpartyDisclaimer()
    {
        return $this->renderAjax('thirdpartyDisclaimer', []);
    }


    /**
     * Installs a given moduleId from marketplace
     */
    public function actionInstall()
    {
        $this->forcePostRequest();

        $moduleId = Yii::$app->request->get('moduleId');

        if (!Yii::$app->moduleManager->hasModule($moduleId)) {
            $this->module->onlineModuleManager->install($moduleId);
        }

        return $this->redirect(['/admin/module/list']);
    }

}
