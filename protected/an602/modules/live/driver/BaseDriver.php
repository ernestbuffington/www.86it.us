<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live\driver;

use yii\base\BaseObject;
use an602\modules\live\components\LiveEvent;
use an602\modules\user\models\User;

/**
 * Base driver for live event storage and distribution
 *
 * @since 1.2
 * @author Luke
 */
abstract class BaseDriver extends BaseObject
{

    /**
     * Sends a live event
     *
     * @param LiveEvent $liveEvent The live event to send
     * @return boolean indicates the sent was successful
     */
    abstract public function send(LiveEvent $liveEvent);

    /**
     * Returns the JavaScript Configuration for this driver
     *
     * @since 1.3
     * @see \an602\widgets\CoreJsConfig
     * @return array the JS Configuratoin
     */
    abstract public function getJsConfig();

    /**
     * This callback will be executed whenever the access rules for a
     * contentcontainer is changed. e.g. user joined a new space as member.
     *
     * @since 1.3
     * @see \an602\modules\live\Module::getLegitimateContentContainerIds()
     */
    public function onContentContainerLegitimationChanged(User $user, $legitimation = [])
    {

    }

}
