<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\components;

use an602\libs\HttpClient;
use Yii;

/**
 * HttpClient
 *
 * @since 1.5
 */
class an602ApiClient extends HttpClient
{
    /**
     * @inheritDoc
     */
    public $baseUrl;

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (empty($this->baseUrl)) {
            $this->baseUrl = Yii::$app->params['an602']['apiUrl'];

        }

        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function beforeSend($request)
    {
        $request->addData([
            'version' => Yii::$app->version,
            'installId' => Yii::$app->getModule('admin')->settings->get('installationId')
        ]);
        parent::beforeSend($request);
    }
}
