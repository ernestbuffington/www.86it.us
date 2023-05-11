<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\menu\widgets;

/**
 * SubTabMenu
 *
 * @since 1.4
 * @package an602\modules\ui\menu\widgets
 */
abstract class SubTabMenu extends TabMenu
{
    /**
     * @var string the title of the panel
     */
    public $panelTitle;

    /**
     * @inheritdoc
     */
    public $template = '@ui/menu/widgets/views/sub-tab-menu.php';

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'nav nav-tabs tab-sub-menu'
        ];
    }

}
