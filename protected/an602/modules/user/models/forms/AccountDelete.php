<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\forms;

use Yii;
use yii\base\Model;
use an602\modules\user\components\CheckPasswordValidator;
use an602\modules\user\models\User;
use an602\modules\user\jobs\SoftDeleteUser;

/**
 * AccountDelete is the model for account deletion.
 *
 * @since 0.5
 */
class AccountDelete extends Model
{

    /**
     * @var string the current password
     */
    public $currentPassword;

    /**
     * @since 1.3
     * @var User the user
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        if (!CheckPasswordValidator::hasPassword()) {
            return [];
        }

        return [
            ['currentPassword', 'required'],
            ['currentPassword', CheckPasswordValidator::class, 'user' => $this->user],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currentPassword' => Yii::t('UserModule.auth', 'Your password'),
        ];
    }

    /**
     * Perform user deletion
     * @since 1.3
     */
    public function performDelete()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->status = User::STATUS_DISABLED;
        $this->user->save();

        Yii::$app->queue->push(new SoftDeleteUser(['user_id' => $this->user->id]));

        return true;
    }

}
