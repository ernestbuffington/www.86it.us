<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\rendering;

use Yii;

/**
 * A LayoutRenderer subclass can be used to render layout based views by setting the $viewPath and $layout properties.
 *
 * The $viewPath defines the path where the target view file resides.
 * For a viewable with the viewName 'myView.php' the renderer will render the view:
 *
 * '<viewPath>/myView.php'
 *
 * where viewPath can also be provided as a Yii alias.
 *
 * The rendered view will be embeded into the given $layout which should point to the layout file
 * and can also be provided as a Yii alias e.g:
 *
 * '@myModule/views/layouts/myLayout.php'
 *
 * @author buddha
 * @since 1.2
 */
class LayoutRenderer extends ViewPathRenderer
{

    /**
     * @var string layout file path
     */
    public $layout;

    /**
     * If a $layout is given the result will embed the rendered viewFile into the
     * given $layout.
     *
     * @param Viewable $viewable
     * @param array $params
     * @return string
     */
    public function render(Viewable $viewable, $params = [])
    {
        $viewParams = $viewable->getViewParams($params);

        // Render the viewFile
        if (!isset($viewParams['content'])) {
            $viewParams['content'] = parent::renderView($viewable, $viewParams);
        }

        // Embed content in layout if valid layout is given.
        $layout = $this->getLayout($viewable);

        if ($layout) {
            return Yii::$app->getView()->renderFile($layout, $viewParams, $viewable);
        } else {
            return $viewParams['content'];
        }
    }

    /**
     * Returns the layout file path.
     * Subclasses may use the $viewable to determine the layout path.
     *
     * @param Viewable $viewable
     * @return string
     */
    protected function getLayout(Viewable $viewable)
    {
        return $this->layout;
    }
}
