<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\components;

use Yii;
use an602\components\behaviors\AccessControl;

/**
 * Base controller for administration section
 *
 * @author luke
 */
class Controller extends \an602\components\Controller
{

    /**
     * @inheritdoc
     */
    public $subLayout = "@an602/modules/admin/views/layouts/main";

    /**
     * @var boolean if true only allows access for system admins else the access is restricted by getAccessRules()
     */
    public $adminOnly = true;

    public $loggedInOnly = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Administration'));

		parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        // Workaround for module configuration actions @see getAccessRules()
        if ($this->module->id != 'admin') {
            $this->adminOnly = false;
        }

        return [
            'acl' => [
                'class' => AccessControl::class,
                'adminOnly' => $this->adminOnly,
                'rules' => $this->getAccessRules()
            ]
        ];
    }

    /**
     * Returns access rules for the standard access control behavior
     *
     * @see AccessControl
     * @return array the access permissions
     */
    public function getAccessRules()
    {
        // Use by default ManageModule permission, if method is not overwritten by custom module
        if ($this->module->id != 'admin') {
            return [
                ['permission' => \an602\modules\admin\permissions\ManageModules::class]
            ];
        }

        return [];
    }

}
