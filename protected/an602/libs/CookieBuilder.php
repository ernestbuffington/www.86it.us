<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\libs;

use Yii;
use yii\di\Container;
use yii\web\Cookie;

/**
 * DI Helper to bake secure cookies.
 *
 * @since 1.13
 */
class CookieBuilder
{
    /**
     * @param $container Container
     * @param $params array
     * @param $config
     * @return Cookie
     */
    public static function build($container, $params, $config)
    {
        $cookie = new Cookie($config);

        if (Yii::$app->request->autoEnsureSecureConnection &&
            Yii::$app->request->isSecureConnection) {
            $cookie->secure = true;
        }

        return $cookie;
    }
}
