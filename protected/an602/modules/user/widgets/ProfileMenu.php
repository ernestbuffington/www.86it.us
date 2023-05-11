<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\modules\user\Module;
use Yii;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\LeftNavigation;
use an602\modules\user\models\User;
use an602\modules\user\permissions\ViewAboutPage;

/**
 * ProfileMenuWidget shows the (usually left) navigation on user profiles.
 *
 * Only a controller which uses the 'application.modules_core.user.ProfileControllerBehavior'
 * can use this widget.
 *
 * The current user can be gathered via:
 *  $user = Yii::$app->getController()->getUser();
 *
 * @since 0.5
 * @author Luke
 */
class ProfileMenu extends LeftNavigation
{

    /**
     * @var User
     */
    public $user;


    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->panelTitle = Yii::t('UserModule.profile', '<strong>Profile</strong> menu');

        /** @var Module $module */
        $module = Yii::$app->getModule('user');

        if (!$module->profileDisableStream) {
            $this->addEntry(new MenuLink([
                'label' => Yii::t('UserModule.profile', 'Stream'),
                'icon' => 'stream',
                'url' => $this->user->createUrl('//user/profile/home'),
                'sortOrder' => 200,
                'isActive' => MenuLink::isActiveState('user', 'profile', ['index', 'home'])
            ]));
        }

        $this->addEntry(new MenuLink([
            'label' => Yii::t('UserModule.profile', 'About'),
            'icon' => 'about',
            'url' => $this->user->createUrl('/user/profile/about'),
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('user', 'profile', 'about'),
            'isVisible' => $this->user->permissionManager->can(ViewAboutPage::class)
        ]));

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->user->isGuest && $this->user->visibility != User::VISIBILITY_ALL) {
            return '';
        }

        return parent::run();
    }

}

?>
