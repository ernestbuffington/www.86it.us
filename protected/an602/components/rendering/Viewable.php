<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\rendering;

/**
 * The Viewable interface is used for Classes that can be rendered by Renderer components.
 * A Renderer can make use of the html, json or text represenation when rendering a viewable.
 *
 * @author buddha
 */
interface Viewable
{

    /**
     * Returns an array of view parameter, required for rendering.
     *
     * @param array $params
     */
    public function getViewParams($params = []);


    /**
     * @return string viewname of this viewable
     */
    public function getViewName();

    /**
     * @return string html content representation of this viewable.
     */
    public function html();

    /**
     * @return string json content representation of this viewable.
     */
    public function json();

    /**
     * @return string text content representation of this viewable.
     */
    public function text();
}
