<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\modules\user\authclient\BaseFormAuth;
use an602\modules\user\authclient\interfaces\PrimaryClient;
use Yii;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\TabMenu;

/**
 * Account Settings Tab Menu
 */
class AccountSettingsMenu extends TabMenu
{

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {

        $this->addEntry(new MenuLink([
            'label' => Yii::t('UserModule.base', 'Basic Settings'),
            'url' => ['/user/account/edit-settings'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('user', 'account', 'edit-settings')
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('UserModule.base', 'Connected Accounts'),
            'url' => ['/user/account/connected-accounts'],
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('user', 'account', 'connected-accounts'),
            'isVisible' => count($this->getSecondaryAuthProviders()) !== 0
        ]));


        parent::init();
    }

    /**
     * Returns optional authclients
     *
     * @return \yii\authclient\ClientInterface[]
     * @throws \yii\base\InvalidConfigException
     */
    protected function getSecondaryAuthProviders()
    {
        $clients = [];
        foreach (Yii::$app->get('authClientCollection')->getClients() as $client) {
            if (!$client instanceof BaseFormAuth && !$client instanceof PrimaryClient) {
                $clients[] = $client;
            }
        }

        return $clients;
    }

}
