<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\forms;

use an602\modules\user\Module;
use Yii;
use an602\modules\user\models\User;
use an602\modules\user\components\CheckPasswordValidator;

/**
 * Form Model for username change
 *
 * @since 1.4
 */
class AccountChangeUsername extends \yii\base\Model
{

    /**
     * @var string the users password
     */
    public $currentPassword;

    /**
     * @var string the users new email address
     */
    public $newUsername;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');

        $rules = [
            ['newUsername', 'required'],
            ['newUsername', 'string', 'min' => $userModule->minimumUsernameLength, 'max' => $userModule->maximumUsernameLength],
            ['newUsername', 'unique', 'targetAttribute' => 'username', 'targetClass' => User::class, 'message' => '{attribute} "{value}" is already in use!'],
            ['newUsername', 'match', 'pattern' => $userModule->validUsernameRegexp, 'message' => Yii::t('UserModule.base', 'Username contains invalid characters.'), 'enableClientValidation' => false],
            ['newUsername', 'trim'],
            [['newUsername'], 'validateForbiddenUsername'],
        ];

        if (CheckPasswordValidator::hasPassword()) {
            $rules[] = ['currentPassword', CheckPasswordValidator::class];
            $rules[] = ['currentPassword', 'required'];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currentPassword' => Yii::t('UserModule.account', 'Current password'),
            'newUsername' => Yii::t('UserModule.account', 'New User name'),
        ];
    }

    /**
     * Sends Change Username E-Mail
     */
    public function sendChangeUsername()
    {
        $user = Yii::$app->user->getIdentity();
        $user->username = $this->newUsername;
        $user->save();

        $mail = Yii::$app->mailer->compose([
            'html' => '@an602/modules/user/views/mails/ChangeUsername',
            'text' => '@an602/modules/user/views/mails/plaintext/ChangeUsername'
        ], [
            'user' => $user,
            'newUsername' => $this->newUsername,
        ]);
        $mail->setTo($user->email);
        $mail->setSubject(Yii::t('UserModule.account', 'Username has been changed'));
        $mail->send();

        return true;
    }

    /**
     * Validate attribute newUsername
     * @param string $attribute
     */
    public function validateForbiddenUsername($attribute, $params)
    {
        if (in_array(strtolower($this->$attribute), Yii::$app->controller->module->forbiddenUsernames)){
            $this->addError($attribute, Yii::t('UserModule.account', 'You cannot use this username.'));
        }
    }

}
