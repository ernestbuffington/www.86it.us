<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\directory;

/**
 * Deprecated Directory Base Module
 * @deprecated since 1.9 
 */
class Module extends \an602\components\Module
{

    /**
     * @deprecated since 1.11 will be removed with v1.12
     */
    public $isCoreModule = false;
    public $memberListSortField = 'profile.lastname';
    public $pageSize = 25;
    public $active = false;
    public $guestAccess = true;
    public $showUserProfilePosts = true;

}
