<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship;

use Yii;

/**
 * Friedship Module
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'an602\modules\friendship\controllers';

    /**
     * Returns if the friendship system is enabled
     *
     * @return boolean is enabled
     */
    public function getIsEnabled()
    {
        if (Yii::$app->getModule('friendship')->settings->get('enable')) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return Yii::t('FriendshipModule.base', 'Friendship');
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
       return [
           'an602\modules\friendship\notifications\Request',
           'an602\modules\friendship\notifications\RequestApproved',
           'an602\modules\friendship\notifications\RequestDeclined'
       ];
    }
}
