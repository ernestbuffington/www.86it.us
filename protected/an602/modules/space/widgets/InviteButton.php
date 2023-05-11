<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2014 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use an602\modules\space\models\Space;
use an602\modules\space\permissions\InviteUsers;
use yii\base\Widget;

/**
 * InviteButton class
 *
 * @author luke
 * @since 0.11
 */
class InviteButton extends Widget
{
    /**
     * @var Space
     */
    public $space;

    /**
     * @inheritDoc
     */
    public function run()
    {
        if (!$this->space->getPermissionManager()->can(new InviteUsers())) {
            return;
        }

        return $this->render('inviteButton', ['space' => $this->space]);
    }

}
