<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\menu\widgets;

/**
 * Class DropdownMenu
 *
 * @since 1.4
 * @package an602\modules\ui\menu\widgets
 */
abstract class DropdownMenu extends Menu
{
    /**
     * @var string the label of the dropdown button
     */
    public $label;

    /**
     * @inheritdoc
     */
    public $template = '@ui/menu/widgets/views/dropdown-menu.php';


    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'btn-group dropdown-navigation'
        ];
    }

}
