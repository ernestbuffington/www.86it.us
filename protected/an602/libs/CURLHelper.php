<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\libs;

use Yii;

/**
 * CURLHelper
 *
 * @author luke
 */
class CURLHelper
{

    /**
     * Returns CURL Default Options
     *
     * @return array
     */
    public static function getOptions()
    {
        $options = [
            CURLOPT_SSL_VERIFYPEER => (Yii::$app->params['curl']['validateSsl']) ? true : false,
            CURLOPT_SSL_VERIFYHOST => (Yii::$app->params['curl']['validateSsl']) ? 2 : 0,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS
        ];

        if (Yii::$app->settings->get('proxy.enabled')) {
            $options[CURLOPT_PROXY] = Yii::$app->settings->get('proxy.server');
            $options[CURLOPT_PROXYPORT] = Yii::$app->settings->get('proxy.port');
            if (defined('CURLOPT_PROXYUSERNAME')) {
                $options[CURLOPT_PROXYUSERNAME] = Yii::$app->settings->get('proxy.user');
            }
            if (defined('CURLOPT_PROXYPASSWORD')) {
                $options[CURLOPT_PROXYPASSWORD] = Yii::$app->settings->get('proxy.password');
            }
            if (defined('CURLOPT_NOPROXY')) {
                $options[CURLOPT_NOPROXY] = Yii::$app->settings->get('proxy.noproxy');
            }
        }

        return $options;
    }
}
