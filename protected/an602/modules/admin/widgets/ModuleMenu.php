<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\modules\ui\menu\widgets\TabMenu;
use Yii;
use yii\helpers\Url;

/**
 * Module Menu
 */
class ModuleMenu extends TabMenu
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->addItem([
            'label' => Yii::t('AdminModule.module', 'Installed'),
            'url' => Url::to(['/admin/module/list']),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'module' && Yii::$app->controller->action->id == 'list'),
        ]);

        parent::init();
    }

}
