<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\widgets;

use Yii;
use yii\base\BaseObject;


/**
 * Class CounterSetItem
 *
 * @since 1.3
 * @see CounterSet
 * @package an602\modules\ui\widgets
 */
class CounterSetItem extends BaseObject
{

    /**
     * @var int the numberic value of this counter item
     */
    public $value;

    /**
     * @var string the label of this counter item. The output will not encoded!
     */
    public $label;

    /**
     * @var array the URL
     */
    public $url;

    /**
     * @var array the Link options
     */
    public $linkOptions = [];


    /**
     * @return bool
     */
    public function hasLink()
    {
        return (!empty($this->url));
    }

    /**
     * @return string
     */
    public function getShortValue()
    {
        return Yii::$app->formatter->asShortInteger($this->value);
    }

}
