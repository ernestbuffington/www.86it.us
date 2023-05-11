<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use Yii;
use an602\modules\admin\models\UserApprovalSearch;
use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\TabMenu;

/**
 * User Administration Menu
 *
 * @author Basti
 */
class UserMenu extends TabMenu
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Overview'),
            'url' => ['/admin/user/index'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('admin', ['user', 'pending-registrations']),
            'isVisible' => Yii::$app->user->can([
                ManageUsers::class,
                ManageGroups::class,
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Settings'),
            'url' => ['/admin/authentication'],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('admin', ['authentication', 'user-permissions']) ||
                          MenuLink::isActiveState('ldap', 'admin'),
            'isVisible' => Yii::$app->user->can(ManageSettings::class)
        ]));

        $approvalCount = UserApprovalSearch::getUserApprovalCount();

        if ($approvalCount > 0) {
            $this->addEntry(new MenuLink([
                'label' => Yii::t('AdminModule.user', 'Pending approvals') . ' <span class="label label-danger">' . $approvalCount . '</span>',
                'url' => ['/admin/approval'],
                'sortOrder' => 300,
                'isActive' => MenuLink::isActiveState('admin', 'approval'),
                'isVisible' => Yii::$app->user->can([
                    ManageUsers::class,
                    ManageGroups::class
                ])
            ]));
        }

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Profiles'),
            'url' => ['/admin/user-profile'],
            'sortOrder' => 400,
            'isActive' => MenuLink::isActiveState('admin', 'user-profile'),
            'isVisible' => Yii::$app->user->can(ManageUsers::class)
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Groups'),
            'url' => ['/admin/group'],
            'sortOrder' => 500,
            'isActive' => MenuLink::isActiveState('admin', 'group'),
            'isVisible' => Yii::$app->user->can(ManageGroups::class)
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'People'),
            'url' => ['/admin/user-people'],
            'sortOrder' => 600,
            'isActive' => MenuLink::isActiveState('admin', 'user-people'),
            'isVisible' => Yii::$app->user->can(ManageSettings::class)
        ]));


        parent::init();
    }

}
