<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\components;

use Yii;
use yii\validators\Validator;
use an602\modules\user\models\User as ModelUser;

/**
 * CheckPasswordValidator checks password of currently logged in user.
 *
 * @author luke
 */
class CheckPasswordValidator extends Validator
{

    /**
     * @var User the user
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        if ($this->user === null) {
            $this->user = Yii::$app->user->getIdentity();
        }

        if ($this->user->currentPassword !== null && !$this->user->currentPassword->validatePassword($value)) {
            $object->addError($attribute, Yii::t('UserModule.auth', 'Your password is incorrect!'));
        }
    }

    /**
     * Checks if current user has a password set.
     *
     * @param User $user the user or null for current
     * @return boolean
     */
    public static function hasPassword(ModelUser $user = null): bool
    {
        if ($user === null) {
            $user = Yii::$app->user->getIdentity();
        }

        if ($user === null) {
            return false;
        }

        return !empty($user->currentPassword->password);
    }

}
