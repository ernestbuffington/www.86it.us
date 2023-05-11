<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\controllers;

use Yii;
use an602\modules\user\components\BaseAccountController;
use an602\modules\notification\models\forms\NotificationSettings;

/**
 * UserController allows users to modify the Notification settings.
 *
 * @since 1.2
 * @author buddha
 */
class UserController extends BaseAccountController
{

    public function actionIndex()
    {
        $form = new NotificationSettings(['user' => Yii::$app->user->getIdentity()]);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }

        return $this->render('notification', ['model' => $form]);
    }

    /**
     * Resets the overwritten user settings to the system defaults
     */
    public function actionReset()
    {
        $this->forcePostRequest();
        $model = new NotificationSettings(['user' => $this->getUser()]);
        $model->resetUserSettings();
        $this->view->saved();
        $this->redirect(['index']);
    }
}
