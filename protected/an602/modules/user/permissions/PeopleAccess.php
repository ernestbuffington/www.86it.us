<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\permissions;

use an602\libs\BasePermission;
use Yii;

class PeopleAccess extends BasePermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'user';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('UserModule.permissions', 'Can Access \'People\'');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('UserModule.permissions', 'Can access \'People\' section.');
    }
}
