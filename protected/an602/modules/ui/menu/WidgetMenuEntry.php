<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\menu;

use an602\modules\ui\icon\widgets\Icon;
use an602\modules\ui\menu\widgets\Menu;
use an602\libs\Html;
use an602\widgets\Link;
use Yii;
use yii\helpers\Url;

/**
 * Class WidgetMenuEntry
 *
 * Widget based menu entry
 *
 * @since 1.4
 * @see Menu
 */
class WidgetMenuEntry extends MenuEntry
{
    public $widgetClass;

    public $widgetOptions;

    /**
     * Renders the link tag for this menu entry
     *
     * @param array $extraHtmlOptions
     * @return string the Html link
     */
    public function renderEntry($extraHtmlOptions = [])
    {
        try {
            return call_user_func($this->widgetClass.'::widget', $this->widgetOptions);
        } catch(\Exception $e) {
            Yii::error($e);
        }
    }

    /**
     * @inheritDoc
     * @since 1.7
     */
    public function getEntryClass()
    {
        return $this->widgetClass;
    }
}
