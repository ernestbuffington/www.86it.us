<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\controllers;

use an602\modules\user\Module;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use an602\components\behaviors\AccessControl;
use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\user\models\Invite;
use an602\modules\user\models\forms\Invite as InviteForm;
use an602\widgets\ModalClose;

/**
 * InviteController for new user invites
 *
 * @since 1.1
 */
class InviteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
            ]
        ];
    }

    /**
     * Invite form and processing action
     *
     * @return string the action result
     * @throws \yii\web\HttpException
     */
    public function actionIndex($adminIsAlwaysAllowed = false)
    {
        $model = new InviteForm();

        $canInviteByEmail = $model->canInviteByEmail($adminIsAlwaysAllowed);
        $canInviteByLink = $model->canInviteByLink($adminIsAlwaysAllowed);
        if (!$canInviteByEmail && !$canInviteByLink) {
            throw new HttpException(403, 'Invite denied!');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->getEmails() as $email) {
                $this->createInvite($email);
            }

            return ModalClose::widget([
                'success' => Yii::t('UserModule.base', 'User has been invited.')
            ]);
        }

        return $this->renderAjax('index', [
            'model' => $model,
            'canInviteByEmail' => $canInviteByEmail,
            'canInviteByLink' => $canInviteByLink,
            'adminIsAlwaysAllowed' => $adminIsAlwaysAllowed,
        ]);
    }

    /**
     * Creates and sends an e-mail invite
     *
     * @param email $email
     */
    protected function createInvite($email)
    {
        $userInvite = new Invite();
        $userInvite->email = $email;
        $userInvite->source = Invite::SOURCE_INVITE;
        $userInvite->user_originator_id = Yii::$app->user->getIdentity()->id;

        $existingInvite = Invite::findOne(['email' => $email]);
        if ($existingInvite !== null) {
            $userInvite->token = $existingInvite->token;
            $existingInvite->delete();
        }

        $userInvite->save();
        $userInvite->sendInviteMail();
    }

    /**
     * @param $adminIsAlwaysAllowed
     * @return string
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionResetInviteLink($adminIsAlwaysAllowed = false)
    {
        $model = new InviteForm();

        if (!Yii::$app->user->can([ManageUsers::class, ManageGroups::class])) {
            $this->forbidden();
        }

        $model->getInviteLink(true);

        $this->view->saved();

        return $this->renderAjax('index', [
            'model' => $model,
            'canInviteByEmail' => $model->canInviteByEmail($adminIsAlwaysAllowed),
            'canInviteByLink' => $model->canInviteByLink($adminIsAlwaysAllowed),
            'adminIsAlwaysAllowed' => $adminIsAlwaysAllowed,
        ]);
    }
}
