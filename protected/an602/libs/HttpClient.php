<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\libs;

use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

/**
 * Class HttpClient
 *
 * @since 1.5
 * @package an602\libs
 * @property $transport CurlTransport
 */
class HttpClient extends Client
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->transport = new CurlTransport();
        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function beforeSend($request)
    {
        $request->setOptions(CURLHelper::getOptions());
        parent::beforeSend($request);
    }

}
