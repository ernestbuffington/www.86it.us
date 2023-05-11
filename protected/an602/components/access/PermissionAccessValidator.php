<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\components\access;

use Yii;
use yii\base\InvalidArgumentException;

class PermissionAccessValidator extends ActionAccessValidator
{
    public $name = 'permission';

    public $strict = false;

    protected function validate($rule)
    {
        if (Yii::$app->user->isAdmin()) {
            return true;
        }

        if (isset($rule[$this->name]) && !empty($rule[$this->name])) {
            return $this->verifyPermission($rule[$this->name], $rule);
        }

        throw new InvalidArgumentException('Invalid permission rule provided for action ' . $this->action);
    }

    /**
     * Checks if the user has the given $permission.
     *
     * @param string|string[]| \an602\libs\BasePermission $permission
     * @param array $params
     * @param array $rule
     * @return bool true if the given $permission is granted
     */
    protected function verifyPermission($permission, $rule)
    {
        return Yii::$app->user->can($permission, $rule);
    }

    protected function extractActions($rule)
    {
        $actions = null;

        if (isset($rule['actions'])) {
            $actions = $rule['actions'];
        }

        return $actions;
    }
}
