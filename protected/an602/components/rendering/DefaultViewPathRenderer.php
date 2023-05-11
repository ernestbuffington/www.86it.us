<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\rendering;

use Yii;
use an602\components\rendering\Viewable;

/**
 * The DefaultViewPathRenderer is used to render Viewables.
 *
 * This Renderer can provide a $defaultView and $defaultViewPath which will be used
 * in case the view file could not be determined by means of the viewName property of the Viewable.
 *
 * The DefaultViewPathRenderer will search for a view file in the given order (without $parent and $subPath settings):
 *
 * - Search for the view relative to the Viewable class
 *
 * `[ViewableClassPath]/views/[viewName].php`
 *
 * - Search for the view within the $defaultViewPath (if given):
 *
 * defaultViewPath/[viewName].php
 *
 * - Use the $defaultView.
 *
 * @author buddha
 * @since 1.2
 */
class DefaultViewPathRenderer extends \an602\components\rendering\ViewPathRenderer
{

    /**
     * @var string fallback view
     */
    public $defaultView;

    /**
     * @var string fallback view path
     */
    public $defaultViewPath;

    /**
     * Returns the view file for the given Viewable.
     *
     * If there was no relative view file found, this function will search for the view file
     * within the $defaultPath or return the $defaultView at last resort.
     *
     * @param \an602\modules\notification\components\Viewable $viewable
     * @return string view file of this notification
     */
    public function getViewFile(Viewable $viewable)
    {
        $viewFile = parent::getViewFile($viewable);

        if (($viewFile === null || !file_exists($viewFile)) && $this->defaultViewPath) {
            $viewFile = Yii::getAlias($this->defaultViewPath) . '/' . $this->suffix($viewable->getViewName());
        }

        if (!file_exists($viewFile) && $this->defaultView) {
            $viewFile = Yii::getAlias($this->defaultView);
        }

        return $viewFile;
    }
}
