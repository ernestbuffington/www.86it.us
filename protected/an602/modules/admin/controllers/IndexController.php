<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use an602\modules\ui\menu\MenuLink;
use Yii;
use an602\modules\admin\components\Controller;
use an602\modules\admin\widgets\AdminMenu;
use yii\web\HttpException;

/**
 * IndexController is the admin section start point.
 *
 * @since 0.5
 */
class IndexController extends Controller
{

    /**
     * @inheritdoc
     */
    public $adminOnly = false;


    /**
     * List all available user groups
     */
    public function actionIndex()
    {
        $adminMenu = new AdminMenu();

        /* @var $firstVisible MenuLink */
        $firstVisible = $adminMenu->getFirstEntry(MenuLink::class, true);

        if(!$firstVisible) {
            throw new HttpException(403);
        }

		return $this->redirect($firstVisible->getUrl());
    }

}
