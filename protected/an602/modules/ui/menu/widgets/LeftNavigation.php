<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\menu\widgets;

/**
 * Class LeftNavigation
 *
 * @since 1.4
 * @package an602\modules\ui\menu\widgets
 */
abstract class LeftNavigation extends Menu
{
    /**
     * @var string the title of the panel
     */
    public $panelTitle;

    /**
     * @inheritdoc
     */
    public $template = '@ui/menu/widgets/views/left-navigation.php';

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'panel panel-default left-navigation'
        ];
    }


}
