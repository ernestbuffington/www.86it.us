<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\controllers;

use Yii;
use an602\modules\user\components\BaseAccountController;
use an602\modules\activity\models\MailSummaryForm;

/**
 * UserController allows users to modify the E-Mail summary settings.
 *
 * @since 1.2
 * @author Luke
 */
class UserController extends BaseAccountController
{

    public function actionIndex()
    {
        $model = new MailSummaryForm();
        $model->user = $this->getUser();
        $model->loadCurrent();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('defaults', [
            'model' => $model
        ]);
    }

    /**
     * Resets the overwritten user settings to the system defaults
     */
    public function actionReset()
    {
        $this->forcePostRequest();
        $model = new MailSummaryForm();
        $model->user = $this->getUser();
        $model->resetUserSettings();

        $this->redirect(['index']);
    }

}
