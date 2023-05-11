<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\widgets;

use Yii;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\TabMenu;

/**
 * Space Administration Menu
 *
 * @author Luke
 */
class DefaultMenu extends TabMenu
{

    /**
     * @var \an602\modules\space\models\Space
     */
    public $space;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.base', 'Basic'),
            'url' => $this->space->createUrl('/space/manage/default/index'),
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState(null, 'default', 'index')
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.base', 'Advanced'),
            'url' => $this->space->createUrl('/space/manage/default/advanced'),
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState(null, 'default', 'advanced')
        ]));

        parent::init();
    }

}
