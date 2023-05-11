<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\modules\admin\permissions\ManageGroups;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\SubTabMenu;
use Yii;
use yii\helpers\Url;

/**
 * Authentication Settings Menu
 *
 * @TODO Refactor/Rename to UserSettingsMenu
 */
class AuthenticationMenu extends SubTabMenu
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.settings', 'General'),
            'url' => ['/admin/authentication'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('admin', 'authentication', 'index'),
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Profile Permissions'),
            'url' => ['/admin/user-permissions'],
            'sortOrder' => 600,
            'isActive' => MenuLink::isActiveState('admin', 'user-permissions'),
            'isVisible' => Yii::$app->user->can(ManageGroups::class)
        ]));

        parent::init();
    }

}
