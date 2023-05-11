<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\permissions;

use an602\modules\admin\components\BaseAdminPermission;

/**
 * ManageSpaces permission allows access to users/spaces section within the admin area.
 *
 * @since 1.2
 */
class ManageSpaces extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_manage_spaces';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Manage Spaces');
        $this->description = \Yii::t('AdminModule.permissions', 'Can manage Spaces within the \'Administration -> Spaces\' section.');
    }

}
