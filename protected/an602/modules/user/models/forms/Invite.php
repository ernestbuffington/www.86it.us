<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\forms;

use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\user\Module;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Model;
use an602\modules\user\models\User;
use yii\helpers\Url;

/**
 * Invite Form Model
 *
 * @since 1.1
 */
class Invite extends Model
{

    /**
     * @var string user's username or email address
     */
    public $emails;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emails'], 'required'],
            ['emails', 'checkEmails']
        ];
    }

    /**
     * Checks a comma separated list of e-mails which should invited.
     * E-Mails needs to be valid and not already registered.
     *
     * @param string $attribute
     * @param array $params
     */
    public function checkEmails($attribute, $params)
    {
        if ($this->$attribute != "") {
            foreach ($this->getEmails() as $email) {
                $validator = new \yii\validators\EmailValidator();
                if (!$validator->validate($email)) {
                    $this->addError($attribute, Yii::t('UserModule.invite', '{email} is not valid!', ["{email}" => $email]));
                    continue;
                }

                if (User::findOne(['email' => $email]) != null) {
                    $this->addError($attribute, Yii::t('UserModule.invite', '{email} is already registered!', ["{email}" => $email]));
                    continue;
                }
            }
        }
    }

    /**
     * E-Mails entered in form
     *
     * @return array the emails
     */
    public function getEmails()
    {
        $emails = [];
        foreach (explode(',', $this->emails) as $email) {
            $emails[] = trim($email);
        }

        return $emails;
    }

    /**
     * Checks if external user invitation setting is enabled
     *
     * @param bool $adminIsAlwaysAllowed
     * @return bool
     * @throws InvalidConfigException
     * @throws \Throwable
     */
    public function canInviteByEmail(bool $adminIsAlwaysAllowed = false)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('user');
        return
            (!Yii::$app->user->isGuest && $module->settings->get('auth.internalUsersCanInviteByEmail'))
            || ($adminIsAlwaysAllowed && Yii::$app->user->can([ManageUsers::class, ManageGroups::class]));
    }

    /**
     * Checks if external user invitation setting is enabled
     *
     * @param bool $adminIsAlwaysAllowed
     * @return bool
     * @throws \Throwable
     * @throws InvalidConfigException
     */
    public function canInviteByLink(bool $adminIsAlwaysAllowed = false)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('user');
        return
            (!Yii::$app->user->isGuest && $module->settings->get('auth.internalUsersCanInviteByLink'))
            || ($adminIsAlwaysAllowed && Yii::$app->user->can([ManageUsers::class, ManageGroups::class]));
    }

    /**
     * @param bool $forceResetToken
     * @return string
     * @throws Exception
     */
    public function getInviteLink($forceResetToken = false)
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('user');
        $settings = $module->settings;

        $token = $settings->get('registration.inviteToken');
        if ($forceResetToken || !$token) {
            $token = Yii::$app->security->generateRandomString(\an602\modules\user\models\Invite::LINK_TOKEN_LENGTH);
            $settings->set('registration.inviteToken', $token);
        }
        return Url::to(['/user/registration/by-link', 'token' => $token], true);
    }
}
