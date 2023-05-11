<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\widgets;

use an602\modules\space\models\Space;
use an602\modules\ui\menu\MenuLink;
use an602\modules\ui\menu\widgets\DropdownMenu;
use Yii;

/**
 * Member Header Controls Menu
 */
class MemberHeaderControlsMenu extends DropdownMenu
{
    /**
     * @var Space
     */
    public $space;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('SpaceModule.manage', 'Remove all members'),
            'url' => $this->space->createUrl('remove-all'),
            'sortOrder' => 100,
            'htmlOptions' => ['data-action-confirm' => Yii::t('SpaceModule.manage', 'All members excluding moderators and administrators of this Space will be removed. All pending invitations and membership requests will be terminated.')],
        ]));

        parent::init();
    }
}
