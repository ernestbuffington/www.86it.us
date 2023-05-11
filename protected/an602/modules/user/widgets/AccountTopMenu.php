<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\modules\admin\widgets\AdminMenu;
use an602\modules\ui\menu\DropdownDivider;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\Menu;
use an602\modules\user\models\User;
use an602\widgets\ModalButton;
use Yii;
use yii\helpers\Url;

/**
 * AccountTopMenu Widget
 *
 * @author luke
 */
class AccountTopMenu extends Menu
{
    public $id = 'account-top-menu';

    /**
     * @var boolean show user name
     */
    public $showUserName = true;

    /**
     * @inheritdoc
     */
    public $template = "@an602/modules/user/widgets/views/accountTopMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->user->isGuest) {

            $signUpText = Yii::$app->getModule('user')->settings->get('auth.anonymousRegistration')
                ? Yii::t('UserModule.base', 'Sign in / up')
                : Yii::t('UserModule.base', 'Sign in');


            $this->addEntry(new MenuLink([
                'link' => ModalButton::primary($signUpText)->load(Url::toRoute('/user/auth/login'))->cssClass('btn-enter'),
                'sortOrder' => 100
            ]));

            parent::init();
            return;
        }

        $user = Yii::$app->user->getIdentity();

        $this->addEntry(new MenuLink([
            'label' => Yii::t('base', 'My profile'),
            'icon' => 'user',
            'url' => $user->createUrl('/user/profile/home'),
            'sortOrder' => 100]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('base', 'Account settings'),
            'icon' => 'edit',
            'url' => Url::toRoute('/user/account/edit'),
            'sortOrder' => 200,
        ]));

        if (AdminMenu::canAccess()) {
            $this->addEntry(new DropdownDivider(['sortOrder' => 300]));


            $this->addEntry(new MenuLink([
                'label' => Yii::t('base', 'Administration'),
                'icon' => 'cogs',
                'url' => Url::toRoute('/admin'),
                'sortOrder' => 400,
            ]));
        }

        $this->addEntry(new DropdownDivider(['sortOrder' => 600]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('base', 'Logout'),
            'id' => 'account-logout',
            'icon' => 'sign-out',
            'pjaxEnabled' => false,
            'url' => Url::toRoute('/user/auth/logout'),
            'htmlOptions' => ['data-method' => 'POST'],
            'sortOrder' => 700,
        ]));

        if (Yii::$app->user->isImpersonated) {
            $this->addEntry(new MenuLink([
                'label' => Yii::t('base', 'Stop impersonation'),
                'id' => 'account-login',
                'icon' => 'sign-in',
                'pjaxEnabled' => false,
                'url' => Url::toRoute('/user/auth/stop-impersonation'),
                'htmlOptions' => ['data-method' => 'POST'],
                'sortOrder' => 800,
            ]));
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'nav'
        ];
    }

}
