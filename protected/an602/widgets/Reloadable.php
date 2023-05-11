<?php
/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 02.02.2019
 * Time: 13:31
 */

namespace an602\widgets;

/**
 * Interface Reloadable
 *
 * This interface is used for JsWidgets which can be reloaded.
 *
 * @package an602\widgets
 * @since 1.4
 */
interface Reloadable
{
    /**
     * @return string|array url used to reload this widget
     */
    public function getReloadUrl();
}