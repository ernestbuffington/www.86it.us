<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\dashboard;

use an602\modules\dashboard\stream\filters\DashboardGuestStreamFilter;
use an602\modules\dashboard\stream\filters\DashboardMemberStreamFilter;
use Yii;

/**
 * Dashboard Module
 *
 * @author Luke
 */
class Module extends \an602\components\Module
{

    /**
     * Possible options to include profile posts into the dashboard stream
     *
     * Default/Null: Default, only include profile posts when user is followed
     * Always: Always include all user profile posts into dashboards
     * Admin Only: For admin users, always include all profile posts (without following)
     */
    const STREAM_AUTO_INCLUDE_PROFILE_POSTS_ALWAYS = 'all';
    const STREAM_AUTO_INCLUDE_PROFILE_POSTS_ADMIN_ONLY = 'admin';

    /**
     * @inheritdocs
     */
    public $controllerNamespace = 'an602\modules\dashboard\controllers';

    /**
     * @since 1.2.4
     * @var string profile
     */
    public $autoIncludeProfilePosts = null;


    /**
     * @since 1.3.14
     * @var boolean hides the activities sidebar widget
     */
    public $hideActivitySidebarWidget = false;

    /**
     * Dashboard stream query filter class used for guest users
     * @var string
     * @since 1.8
     */
    public $guestFilterClass = DashboardGuestStreamFilter::class;

    /**
     * Dashboard stream query filter class used for members of the network
     * @var string
     * @since 1.8
     */
    public $memberFilterClass = DashboardMemberStreamFilter::class;

    /**
     * @return static
     */
    public static function getModuleInstance()
    {
        /* @var $module static */
        $module = Yii::$app->getModule('dashboard');
        return $module;
    }

}
