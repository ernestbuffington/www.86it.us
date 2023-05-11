<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live\components;

use Yii;
use yii\base\Component;

/**
 * Live Data Sender
 *
 * @since 1.2
 * @author Luke
 */
class Sender extends Component
{

    /**
     * @var \an602\modules\live\driver\BaseDriver|array|string
     */
    public $driver = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->driver = Yii::createObject($this->driver);
    }

    /**
     * Sends a live event
     * 
     * @param LiveEvent $event the live event
     */
    public function send($event)
    {
        return $this->driver->send($event);
    }

}
