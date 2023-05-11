<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use an602\components\access\ControllerAccess;
use an602\modules\admin\models\UserApprovalSearch;
use an602\modules\admin\Module;
use an602\modules\user\models\ProfileField;
use Yii;
use yii\web\HttpException;
use an602\modules\admin\components\Controller;
use an602\modules\admin\models\forms\ApproveUserForm;

/**
 * ApprovalController handels new user approvals
 */
class ApprovalController extends Controller
{
    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    public const ACTION_APPROVE = 'approve';
    public const ACTION_DECLINE = 'decline';

    public const USER_SETTINGS_SCREEN_KEY = 'admin_approval_screen_profile_fields_id';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->subLayout = '@admin/views/layouts/user';
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Approval'));
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            [ControllerAccess::RULE_LOGGED_IN_ONLY],
            ['checkCanApproveUsers'],
        ];
    }

    /**
     * @param $rule
     * @param $access
     * @return bool
     * @throws \Throwable
     */
    public function checkCanApproveUsers($rule, $access)
    {
        if (!Yii::$app->user->getIdentity()->canApproveUsers()) {
            $access->code = 403;
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isAdmin()) {
            $this->subLayout = "@an602/modules/admin/views/approval/_layoutNoAdmin";
        }

        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $searchModel = new UserApprovalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Get available profile fields for screen options
        $availableProfileFields = ProfileField::find()
            ->joinWith('category')
            ->orderBy([
                'profile_field_category.sort_order' => SORT_ASC,
                'profile_field.sort_order' => SORT_ASC
            ])
            ->where(['profile_field.show_at_registration' => true])
            ->andWhere(['not', ['profile_field.internal_name' => ['firstname', 'lastname']]])
            ->all();

        // Get or set screen options
        $screenProfileFieldsId = null;

        /** @var Module $module */
        $module = Yii::$app->getModule('admin');
        $module->settings->user()->getSerialized(self::USER_SETTINGS_SCREEN_KEY, []);
        if (Yii::$app->request->post('screenProfileFieldsId')) {
            $screenProfileFieldsId = Yii::$app->request->post('screenProfileFieldsId');
            $module->settings->user()->setSerialized(self::USER_SETTINGS_SCREEN_KEY, $screenProfileFieldsId);
        }
        $profileFieldsColumns = !$screenProfileFieldsId ? [] : ProfileField::find()
            ->where(['id' => $screenProfileFieldsId])
            ->indexBy('id')
            ->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'availableProfileFields' => $availableProfileFields,
            'profileFieldsColumns' => $profileFieldsColumns,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionApprove($id)
    {
        $model = new ApproveUserForm($id);
        $model->setApprovalDefaults();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->approve()) {
                $this->view->success(Yii::t('AdminModule.user', 'The registration was approved and the user was notified by email.'));
                return $this->redirect(['index']);
            }
            $this->view->error(Yii::t('AdminModule.user', 'Could not approve the user!'));
        }

        return $this->render('approve', [
            'model' => $model->user,
            'approveFormModel' => $model
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDecline($id)
    {
        $model = new ApproveUserForm($id);
        $model->setDeclineDefaults();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->decline()) {
                $this->view->success(Yii::t('AdminModule.user', 'The registration was declined and the user was notified by email.'));
                return $this->redirect(['index']);
            }
            $this->view->error(Yii::t('AdminModule.user', 'Could not decline the user!'));
        }

        return $this->render('decline', [
            'model' => $model->user,
            'approveFormModel' => $model
        ]);
    }

    /**
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBulkActions()
    {
        /** @var string $action */
        $action = Yii::$app->request->post('action');
        /** @var array $usersId */
        $usersId = Yii::$app->request->post('ids');

        if (!$usersId) {
            $this->view->error(Yii::t('AdminModule.user', 'No users were selected.'));
            return $this->redirect(['index']);
        }

        $model = new ApproveUserForm($usersId);

        if ($action === self::ACTION_APPROVE && $model->bulkApprove()) {
            $this->view->success(Yii::t('AdminModule.user', 'The registrations were approved and the users were notified by email.'));
            return $this->redirect(['index']);
        } elseif ($action === self::ACTION_DECLINE && $model->bulkDecline()) {
            $this->view->success(Yii::t('AdminModule.user', 'The registrations were declined and the users were notified by email.'));
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400, 'Invalid action!');
        }
    }

}
