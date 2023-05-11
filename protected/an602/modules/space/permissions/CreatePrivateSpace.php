<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\permissions;

use an602\libs\BasePermission;
use Yii;

/**
 * CreatePrivateSpace Permission
 */
class CreatePrivateSpace extends BasePermission
{

    /**
     * @inheritdoc
     */
    protected $id = 'create_private_space';
    
    /**
     * @inheritdoc
     */
    protected $title = 'Create Private Spaces';

    /**
     * @inheritdoc
     */
    protected $description = 'Can create hidden (private) Spaces.';

    /**
     * @inheritdoc
     */
    protected $moduleId = 'space';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    public function __construct($config = []) {
        parent::__construct($config);
        
        $this->title = Yii::t('SpaceModule.permissions', 'Create Private Spaces');
        $this->description = Yii::t('SpaceModule.permissions', 'Can create hidden (private) Spaces.');
    }    
}
