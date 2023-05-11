<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\installer\controllers;


use an602\components\access\ControllerAccess;
use an602\components\Controller;


/**
 * Index Controller shows a simple welcome page.
 *
 * @author luke
 */
class IndexController extends Controller
{
    /**
     * Allow guest access independently from guest mode setting.
     *
     * @var string
     */
    public $access = ControllerAccess::class;

    /**
     * Index View just provides a welcome page
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }

    /**
     * Checks if we need to call SetupController or ConfigController.
     */
    public function actionGo()
    {
        if ($this->module->checkDBConnection()) {
            return $this->redirect(['setup/finalize']);
        } else {
            return $this->redirect(['setup/prerequisites']);
        }
    }

}
