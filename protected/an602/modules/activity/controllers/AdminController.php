<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\controllers;

use an602\modules\admin\components\Controller;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\activity\models\MailSummaryForm;
use Yii;

/**
 * AdminController is for system administrators to set activity e-mail defaults.
 *
 * @since 1.2
 * @author Luke
 */
class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => ManageSettings::class],
            ['permissions' => [ManageUsers::class], 'actions' => ['reset-all-users']],
        ];
    }

    public function actionDefaults()
    {
        $this->subLayout = '@admin/views/layouts/setting';
        $model = new MailSummaryForm();

        $model->loadCurrent();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('defaults', [
            'model' => $model
        ]);
    }

    /**
     * Resets the overwritten settings of all users to the system defaults
     */
    public function actionResetAllUsers()
    {
        $this->forcePostRequest();
        $model = new MailSummaryForm();
        $model->resetAllUserSettings();

        $this->view->saved();
        $this->redirect(['defaults']);
    }

}
