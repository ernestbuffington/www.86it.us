<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 30.07.2017
 * Time: 04:15
 */

namespace an602\modules\content\components;


use an602\components\access\PermissionAccessValidator;

class ContentContainerPermissionAccess extends PermissionAccessValidator
{
    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    protected function verifyPermission($permission, $rule)
    {
        return parent::verifyPermission($permission, $rule) ||
            (($this->contentContainer instanceof ContentContainerActiveRecord) && $this->contentContainer->can($permission, $rule));
    }
}
