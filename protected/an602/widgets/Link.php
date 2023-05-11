<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 13.06.2017
 * Time: 22:32
 */

namespace an602\widgets;


use an602\components\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Helper class for creating links.
 *
 * @package an602\widgets
 */
class Link extends Button
{
    public $_link = true;

    public static function to($text, $url = '#', $pjax = true) {
        return self::asLink($text, $url)->pjax($pjax);
    }

    public static function withAction($text, $action, $url = null, $target = null) {
        return self::asLink($text)->action($action,$url, $target);
    }

    /**
     * @param $url
     * @return $this
     */
    public function post($url)
    {
        // Note data-method automatically prevents pjax
        $this->href($url);
        $this->htmlOptions['data-method'] = 'POST';
        return $this;
    }

    /**
     * @param string $url
     * @param bool $pjax
     * @return $this
     */
    public function href($url = '#', $pjax = true)
    {
        $this->link($url);
        $this->pjax($pjax);
        return $this;
    }

    public function target($target)
    {
        $this->htmlOptions['target'] = $target;
        return $this;
    }

    public function blank()
    {
        return $this->target('_blank');
    }
}
