<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use yii\base\Widget;

/**
 * PanelMenuWidget add an dropdown menu to the panel header
 *
 * @package an602.widgets
 * @since 0.5
 * @author Andreas Strobel
 */
class PanelMenu extends Widget
{

    /**
     * @var String unique id from panel element
     */
    public $id = '';

    /**
     * Workaround to inject menu items to PanelMenu
     *
     * @deprecated since version 0.9
     * @internal description
     * @var String
     */
    public $extraMenus = '';


    /**
     * @inheritDoc
     */
    public function init()
    {
        return parent::init();
    }

    /**
     * Displays / Run the Widgets
     */
    public function run()
    {
        return $this->render('panelMenu', [
            'id' => $this->id,
            'extraMenus' => $this->extraMenus,
        ]);
    }

}
