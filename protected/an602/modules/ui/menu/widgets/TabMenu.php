<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\menu\widgets;

use an602\modules\ui\menu\MenuLink;

/**
 * Class TabMenu
 *
 * @since 1.4
 * @package an602\modules\ui\menu\widgets
 */
abstract class TabMenu extends Menu
{
    /**
     * @inheritdoc
     */
    public $template = '@ui/menu/widgets/views/tab-menu.php';

    /**
     * @var bool whether or not to skip rendering if only one menu link is given
     */
    public $renderSingleTab = false;

    public function render($view, $params = [])
    {
        if(!$this->renderSingleTab && !$this->hasMultipleEntries(MenuLink::class)) {
            return '';
        }

        return parent::render($view, $params);
    }

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'tab-menu'
        ];
    }

}
