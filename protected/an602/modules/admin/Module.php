<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin;

use Yii;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;

/**
 * Admin Module
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'an602\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'index';

    /**
     * @inheritdoc
     */
    public $isCoreModule = true;

    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
     * @var boolean check daily for new an602 version
     */
    public $dailyCheckForNewVersion = true;

    /**
     * @var boolean allow admins to impersonate other users
     */
    public $allowUserImpersonate = true;

    /**
     * @since 1.3.2
     * @var boolean show incomplete setup warning on the dashboard for admins
     */
    public $showDashboardIncompleteSetupWarning = true;

    /**
     * @since 1.4
     * @var array list of script urls which should not be cached on the client side
     */
    public $defaultReloadableScripts = [
        'https://platform.twitter.com/widgets.js'
    ];

    /**
     * @var int seconds before delete old pending registrations messages
     */
    public $cleanupPendingRegistrationInterval = 60 * 60 * 24 * 90;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('AdminModule.base', 'Admin');
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof Space) {
            return [];
        } elseif ($contentContainer instanceof User) {
            return [];
        }

        return [
            new permissions\ManageModules(),
            new permissions\ManageSettings(),
            new permissions\SeeAdminInformation(),
            new permissions\ManageUsers(),
            new permissions\ManageGroups(),
            new permissions\ManageSpaces(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        if (Yii::$app->user->isAdmin()) {
            return [
                'an602\modules\admin\notifications\NewVersionAvailable'
            ];
        }

        return [];
    }

}
