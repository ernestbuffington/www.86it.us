<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\authclient;

use an602\modules\user\authclient\interfaces\StandaloneAuthClient;
use Yii;

/**
 * Extended version of AuthAction with AuthClient support which are not handled
 * by AuthAction directly
 *
 * @since 1.1.2
 * @author Luke
 */
class AuthAction extends \yii\authclient\AuthAction
{

    /**
     * @inheritdoc
     *
     * @param StandaloneAuthClient $client
     * @return \yii\web\Response response instance.
     */
    public function auth($client,  $authUrlParams = [])
    {
        Yii::$app->session->set('loginRememberMe', (boolean) Yii::$app->request->get('rememberMe'));

        if ($client instanceof StandaloneAuthClient) {
            return $client->authAction($this);
        }

        return parent::auth($client);
    }

    /**
     * @inheritdoc
     */
    public function authSuccess($client)
    {
        return parent::authSuccess($client);
    }

}
