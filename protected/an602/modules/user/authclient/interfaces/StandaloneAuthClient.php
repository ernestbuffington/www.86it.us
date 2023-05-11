<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\authclient\interfaces;

use an602\modules\user\authclient\AuthAction;

/**
 * StandaloneAuthClient allows implementation of custom authclients
 * which not relies on auth handling by AuthAction
 *
 * @see \yii\authclient\AuthAction
 * @since 1.1.2
 * @author Luke
 */
interface StandaloneAuthClient
{

    /**
     * Custom auth action implementation
     * 
     * @param AuthAction $authAction
     * @return \yii\web\Response response instance.
     */
    public function authAction($authAction);
}
