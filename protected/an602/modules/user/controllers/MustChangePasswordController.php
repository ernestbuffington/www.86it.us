<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\controllers;

use an602\components\Controller;
use an602\modules\user\models\Password;
use an602\modules\user\models\User;
use Yii;

/**
 * Must Change Password
 *
 * @since 1.8
 */
class MustChangePasswordController extends Controller
{

    /**
     * @inheritdoc
     */
    public $layout = "@an602/modules/user/views/layouts/main";

    /**
     * Must Change Password Form Action
     * Display a form to force user to change password.
     */
    public function actionIndex()
    {
        Yii::$app->getModule('live')->isActive = false;

        if (!Yii::$app->user->mustChangePassword()) {
            return $this->goHome();
        }

        if (!($model = Password::findOne(['user_id' => Yii::$app->user->id]))) {
            $model = new Password();
            $model->user_id = Yii::$app->user->id;
        }
        $model->scenario = 'changePassword';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->newPassword);
            if ($model->save()) {
                /* @var User $user */
                if ($user = Yii::$app->user->getIdentity()) {
                    $user->setMustChangePassword(false);
                }
                $this->view->success(Yii::t('UserModule.base', 'Password changed'));
                return $this->goHome();
            }
        }

        return $this->render('index', ['model' => $model]);
    }

}
