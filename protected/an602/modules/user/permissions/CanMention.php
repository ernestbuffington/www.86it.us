<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\permissions;

use Yii;
use an602\modules\user\models\User;

/**
 * Can Mention Permission
 */
class CanMention extends \an602\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultState = self::STATE_ALLOW;

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        User::USERGROUP_SELF,
        User::USERGROUP_USER,
        User::USERGROUP_FRIEND
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        User::USERGROUP_SELF,
    ];

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->title = \Yii::t('UserModule.base', 'Mentioning');
        $this->description = \Yii::t('UserModule.base', 'Allow users to mention you');
    }

    /**
     * @inheritdoc
     */
    protected $title;

    /**
     * @inheritdoc
     */
    protected $description;

    /**
     * @inheritdoc
     */
    protected $moduleId = 'user';

}
