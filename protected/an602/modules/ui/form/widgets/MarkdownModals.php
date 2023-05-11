<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\form\widgets;

use an602\components\Widget;
use an602\widgets\LayoutAddons;

/**
 * Class MarkdownModals provides modals which are added used by the Markdown widget.
 * The widget is automatically added to the layout addons.
 *
 * @see LayoutAddons
 * @since 1.3
 */
class MarkdownModals extends Widget
{
    public function run()
    {
        return $this->render('markdownModals');
    }

}
