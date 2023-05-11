<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\permissions;

use an602\libs\BasePermission;
use Yii;

class SpaceDirectoryAccess extends BasePermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'space';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('SpaceModule.permissions', 'Can Access \'Spaces\'');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('SpaceModule.permissions', 'Can access the \'Spaces\' section.');
    }
}
