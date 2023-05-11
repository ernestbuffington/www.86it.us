<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\components;

use an602\modules\content\components\ContentContainerController;
use an602\modules\content\components\ContentContainerControllerAccess;
use an602\modules\space\models\Space;

/**
 * Default Space Manage Controller
 *
 * @author luke
 */
class Controller extends ContentContainerController
{

    protected function getAccessRules() {
        return [
            ['login'],
            [ContentContainerControllerAccess::RULE_USER_GROUP_ONLY => [Space::USERGROUP_ADMIN]]
        ];
    }
}
