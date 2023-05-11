<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use Yii;
use an602\modules\ui\menu\widgets\Menu;
use an602\modules\user\components\User;

/**
 * TopMenuWidget is the primary top navigation class extended from MenuWidget.
 *
 * @since 0.5
 * @author Luke
 */
class TopMenu extends Menu
{

    /**
     * @inheritdoc
     */
    public $id = 'top-menu-nav';

    /**
     * @inheritdoc
     */
    public $template = 'topNavigation';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Don't show top menu if guest access is disabled
        if (Yii::$app->user->isGuest && !User::isGuestAccessEnabled()) {
            $this->template = '';
        }
    }



}
