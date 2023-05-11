<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use Yii;
use yii\helpers\Json;
use an602\assets\PjaxAsset;

/**
 * Pjax Widget
 *
 * @author Luke
 */
class Pjax extends \an602\components\Widget
{

    /**
     * @var array options passed to pjax scrpit
     */
    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->clientOptions['pushRedirect'] = true;
        $this->clientOptions['replaceRedirect'] = true;
        $this->clientOptions['cache'] = false;
        $this->clientOptions['timeout'] = 5000;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $view = $this->getView();
        PjaxAsset::register($view);
        
        $view->registerJsConfig('client.pjax', [
            'active' => self::isActive(),
            'options' => $this->clientOptions
        ]);
    }
    
    public static function isActive()
    {
        return Yii::$app->params['enablePjax'];
    }

}
