<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\controllers;

use yii\helpers\Url;
use an602\components\Controller;

/**
 * HomeController redirects to the home page
 *
 * @author luke
 * @since 1.2
 */
class HomeController extends Controller
{

    /**
     * Redirects to the home controller/action
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(Url::home());
    }
}
