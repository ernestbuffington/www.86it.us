<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\widgets;

use an602\components\Widget;
use an602\libs\Html;
use Yii;


/**
 * Labels for Wall Entries
 * This widget will attached labels like Pinned, Archived to Wall Entries
 *
 * @since 1.2.2
 */
class Label extends BootstrapComponent
{

    /**
     * @since 1.9
     */
    public const TYPE_LIGHT = 'light';

    public $_sortOrder = 1000;
    public $encode = true;

    public $_link;
    public $_action;

    /**
     * @param string $text Label text
     * @return static
     * @since 1.9
     */
    public static function light($text)
    {
        return new static(['type' => static::TYPE_LIGHT, 'text' => $text]);
    }

    public function sortOrder($sortOrder)
    {
        $this->_sortOrder = $sortOrder;
        return $this;
    }

    /**
     * Adds a data-action-click handler to the button.
     * @param $handler
     * @param null $url
     * @param null $target
     * @return static
     */
    public function action($handler, $url = null, $target = null)
    {
        $this->_link = Link::withAction($this->getText(), $handler, $url, $target);
        return $this;
    }

    public function withLink($link)
    {
        if($link instanceof Link) {
            $this->_link = $link;
        }

        return $this;
    }

    /**
     * @return string renders and returns the actual html element by means of the current settings
     */
    public function renderComponent()
    {
        $result = Html::tag('span', $this->getText(), $this->htmlOptions);
        if($this->_link) {
            $result = (string) $this->_link->setText($result);
        }
        return $result;
    }

    /**
     * @return string the bootstrap css base class
     */
    public function getComponentBaseClass()
    {
        return 'label';
    }

    /**
     * @return string the bootstrap css class by $type
     */
    public function getTypedClass($type)
    {
        return 'label-'.$type;
    }

    public function getWidgetOptions()
    {
        $options = parent::getWidgetOptions();
        $options['_link'] = $this->_link;
        return $options;
    }

    public static function sort(&$labels)
    {
        usort($labels, function ($a, $b) {
            if ($a->_sortOrder == $b->_sortOrder) {
                return 0;
            } elseif ($a->_sortOrder < $b->_sortOrder) {
                return - 1;
            } else {
                return 1;
            }
        });

        return $labels;
    }
}

?>
