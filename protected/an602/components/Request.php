<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components;

use an602\models\Setting;
use Yii;

/**
 * @inheritdoc
 *
 *
 * @author luke
 */
class Request extends \yii\web\Request
{
    /**
     * Whenever a secure connection is detected, force it.
     * @var bool
     * @since 1.13
     */
    public $autoEnsureSecureConnection = true;

    /**
     * Http header name for view context information
     * @see \an602\modules\ui\view\components\View::$viewContext
     */
    const HEADER_VIEW_CONTEXT = 'AN602-VIEW-CONTEXT';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Setting::isInstalled()) {
            $secret = Yii::$app->settings->get('secret');
            if ($secret != "") {
                $this->cookieValidationKey = $secret;
            }
        }

        if ($this->cookieValidationKey == '') {
            $this->cookieValidationKey = 'installer';
        }
    }

    /**
     * @return string|null the value of http header `AN602-VIEW-CONTEXT`
     */
    public function getViewContext()
    {
        return $this->getHeaders()->get(static::HEADER_VIEW_CONTEXT);
    }
}
