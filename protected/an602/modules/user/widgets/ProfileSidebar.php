<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\widgets\BaseSidebar;

/**
 * ProfileSidebar implements the sidebar for the user profiles.
 * 
 * @since 0.5
 * @author Luke
 */
class ProfileSidebar extends BaseSidebar
{

    /**
     * @var \an602\modules\user\models\User the user this sidebar belongs to
     */
    public $user;

}

?>
