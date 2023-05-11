<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\SubTabMenu;
use Yii;
use yii\helpers\Url;

/**
 * Group Administration Menu
 */
class GroupMenu extends SubTabMenu
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('AdminModule.user', 'Overview'),
            'url' => ['/admin/group/index'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('admin', 'group', 'index'),
        ]));
        parent::init();
    }

}
