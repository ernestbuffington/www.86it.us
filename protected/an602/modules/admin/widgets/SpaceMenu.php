<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use Yii;
use yii\helpers\Url;
use an602\modules\ui\menu\MenuLink;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageSpaces;
use an602\modules\ui\menu\widgets\TabMenu;

/**
 * Space Administration Menu
 *
 * @author Luke
 */
class SpaceMenu extends TabMenu
{
    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.space', 'Overview'),
            'url' => Url::toRoute(['/admin/space/index']),
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('admin', 'space', 'index'),
            'isVisible' => Yii::$app->user->can(ManageSpaces::class)
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.space', 'Settings'),
            'url' => Url::toRoute(['/admin/space/settings']),
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('admin', 'space', 'settings'),
            'isVisible' => Yii::$app->user->can(ManageSettings::class)
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.space', 'Permissions'),
            'url' => Url::toRoute(['/admin/space/permissions']),
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('admin', 'space', 'permissions'),
            'isVisible' => Yii::$app->user->can(ManageSettings::class)
        ]));

        parent::init();
    }

}
