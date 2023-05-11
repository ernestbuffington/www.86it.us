<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use Yii;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\SubTabMenu;

/**
 * Group Administration Menu
 */
class GroupManagerMenu extends SubTabMenu
{

    /**
     * @var \an602\modules\user\models\Group
     */
    public $group;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Settings'),
            'url' => ['/admin/group/edit', 'id' => $this->group->id],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('admin', 'group', 'edit')
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', "Permissions"),
            'url' => ['/admin/group/manage-permissions', 'id' => $this->group->id],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('admin', 'group', 'manage-permissions')
        ]));


        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', "Members"),
            'url' => ['/admin/group/manage-group-users', 'id' => $this->group->id],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('admin', 'group', 'manage-group-users')
        ]));

        parent::init();
    }

}
