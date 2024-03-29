<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use an602\compat\HForm;
use an602\components\export\ArrayColumn;
use an602\components\export\DateTimeColumn;
use an602\components\export\SpreadsheetExport;
use an602\modules\admin\components\Controller;
use an602\modules\admin\models\forms\PasswordEditForm;
use an602\modules\admin\models\forms\UserDeleteForm;
use an602\modules\admin\models\forms\UserEditForm;
use an602\modules\admin\models\UserSearch;
use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\user\models\forms\Registration;
use an602\modules\user\models\Invite;
use an602\modules\user\models\Profile;
use an602\modules\user\models\ProfileField;
use an602\modules\user\models\User;
use an602\modules\user\services\AuthClientUserService;
use Yii;
use yii\db\Query;
use yii\web\HttpException;

/**
 * User management
 *
 * @since 0.5
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->appendPageTitle(Yii::t('AdminModule.base', 'Users'));
        $this->subLayout = '@admin/views/layouts/user';
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => [ManageUsers::class, ManageGroups::class]],
            ['permissions' => [ManageSettings::class], 'actions' => ['index']]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can([new ManageUsers(), new ManageGroups()])) {
            return $this->redirect(['list']);
        } elseif (Yii::$app->user->can(ManageSettings::class)) {
            return $this->redirect(['/admin/authentication']);
        } else {
            return $this->forbidden();
        }
    }

    /**
     * Returns a List of Users
     */
    public function actionList()
    {
        $searchModel = new UserSearch();
        $searchModel->status = User::STATUS_ENABLED;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $showPendingRegistrations = (Invite::find()->count() > 0 && Yii::$app->user->can([new ManageUsers(), new ManageGroups()]));

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'showPendingRegistrations' => $showPendingRegistrations
        ]);
    }

    /**
     * Edits a user
     * @return string
     * @throws HttpException
     */
    public function actionEdit()
    {
        $user = UserEditForm::findOne(['id' => Yii::$app->request->get('id')]);
        $user->initGroupSelection();

        if ($user == null) {
            throw new HttpException(404, Yii::t('AdminModule.user', 'User not found!'));
        }

        $authClientUserService = new AuthClientUserService($user);

        $canEditAdminFields = Yii::$app->user->isAdmin() || !$user->isSystemAdmin();
        $canEditPassword = $canEditAdminFields && $authClientUserService->canChangePassword();

        $user->scenario = 'editAdmin';
        $user->profile->scenario = Profile::SCENARIO_EDIT_ADMIN;
        $profile = $user->profile;

        if ($canEditPassword) {
            if (!($password = PasswordEditForm::findOne(['user_id' => $user->id]))) {
                $password = new PasswordEditForm();
                $password->user_id = $user->id;
            }
            $password->mustChangePassword = $user->mustChangePassword();
        }

        // Build Form Definition
        $definition = [];
        $definition['elements'] = [];
        // Add User Form
        $definition['elements']['User'] = [
            'type' => 'form',
            'title' => Yii::t('AdminModule.user', 'Account'),
            'elements' => [
                'id' => [
                    'type' => 'text',
                    'class' => 'form-control',
                    'readonly' => true,
                ],
                'username' => [
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 25,
                    'readonly' => !$authClientUserService->canChangeUsername(),
                ],
                'email' => [
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 100,
                    'readonly' => !$authClientUserService->canChangeEmail()
                ],
                'groupSelection' => [
                    'id' => 'user_edit_groups',
                    'type' => 'multiselectdropdown',
                    'items' => UserEditForm::getGroupItems(),
                    'options' => [
                        'data-placeholder' => Yii::t('AdminModule.user', 'Select Groups'),
                        'data-placeholder-more' => Yii::t('AdminModule.user', 'Add Groups...'),
                        'data-tags' => 'false'
                    ],
                    'maxSelection' => 250,
                    'isVisible' => Yii::$app->user->can(new ManageGroups())
                ],
            ],
        ];

        if ($canEditAdminFields) {
            $definition['elements']['User']['elements']['status'] = [
                'type' => 'dropdownlist',
                'class' => 'form-control',
                'items' => User::getStatusOptions(false),
            ];

            $definition['elements']['User']['elements']['visibility'] = [
                'type' => 'dropdownlist',
                'class' => 'form-control',
                'items' => User::getVisibilityOptions(),
            ];
        }

        // Change Password Form
        if ($canEditPassword) {
            $definition['elements']['Password'] = [
                'type' => 'form',
                'title' => Yii::t('AdminModule.user', 'Password'),
                'elements' => [
                    'newPassword' => [
                        'type' => 'password',
                        'class' => 'form-control',
                        'maxlength' => 45,
                    ],
                    'newPasswordConfirm' => [
                        'type' => 'password',
                        'class' => 'form-control',
                        'maxlength' => 45,
                    ],
                    'mustChangePassword' => [
                        'type' => 'checkbox',
                        'class' => 'form-control',
                        'label' => Yii::t('UserModule.base', 'Force password change upon next login'),
                    ],
                ],
            ];
        }

        // Add Profile Form
        $definition['elements']['Profile'] = array_merge(['type' => 'form'], $profile->getFormDefinition());

        // Get Form Definition
        $definition['buttons'] = [
            'save' => [
                'type' => 'submit',
                'label' => Yii::t('AdminModule.user', 'Save'),
                'class' => 'btn btn-primary',
            ],

        ];

        if ($canEditAdminFields) {
            if (!$user->isCurrentUser()) {
                $definition['buttons']['delete'] = [
                    'type' => 'submit',
                    'label' => Yii::t('AdminModule.user', 'Delete'),
                    'class' => 'btn btn-danger',
                ];
            }
        }

        $form = new HForm($definition);
        $form->models['User'] = $user;
        $form->models['Profile'] = $profile;
        if ($canEditPassword) {
            $form->models['Password'] = $password;
        }

        if ($form->submitted('save') && $form->validate()) {
            if ($canEditPassword) {
                if (!empty($password->newPassword)) {
                    $password->setPassword($password->newPassword);
                }
                $user->setMustChangePassword($password->mustChangePassword);
            }
            if ($form->save()) {
                $this->view->saved();
                return $this->redirect(['/admin/user']);
            }
        }

        if ($form->submitted('delete')) {
            return $this->redirect(['delete', 'id' => $user->id]);
        }

        return $this->render('edit', [
            'hForm' => $form,
            'user' => $user
        ]);
    }

    public function actionAdd()
    {
        $registration = new Registration();
        $registration->enableEmailField = true;
        $registration->enableUserApproval = false;
        $registration->enableMustChangePassword = true;
        if ($registration->submitted('save') && $registration->validate() && $registration->register()) {
            return $this->redirect(['edit', 'id' => $registration->getUser()->id]);
        }

        return $this->render('add', ['hForm' => $registration]);
    }

    /**
     * Deletes a user permanently
     * @throws HttpException
     */
    public function actionDelete($id)
    {
        $user = User::findOne(['id' => $id]);

        $this->checkUserAccess($user);

        if ($user->isCurrentUser()) {
            throw new HttpException(400, Yii::t('AdminModule.user', 'You cannot delete yourself!'));
        }

        $model = new UserDeleteForm(['user' => $user]);
        if ($model->load(Yii::$app->request->post()) && $model->performDelete()) {
            $this->view->info(Yii::t('AdminModule.user', 'User deletion process queued.'));
            return $this->redirect(['list']);
        }
        return $this->render('delete', ['model' => $model]);
    }

    public function checkUserAccess(User $user = null)
    {
        if (!$user) {
            throw new HttpException(404, Yii::t('AdminModule.user', 'User not found!'));
        }

        if ($user->isSystemAdmin() && !Yii::$app->user->isAdmin()) {
            throw new HttpException(403);
        }
    }

    /**
     * Redirect to user profile
     *
     * @param int $id
     * @return \yii\base\Response the response
     * @throws HttpException
     */
    public function actionViewProfile($id)
    {
        $user = User::findOne(['id' => $id]);
        if ($user === null) {
            throw new HttpException(404);
        }

        return $this->redirect($user->getUrl());
    }

    public function actionEnable($id)
    {
        $this->forcePostRequest();

        $user = User::findOne(['id' => $id]);
        if ($user === null) {
            throw new HttpException(404);
        }

        $user->status = User::STATUS_ENABLED;
        $user->save();

        return $this->redirect(['list']);
    }

    public function actionDisable($id)
    {
        $this->forcePostRequest();

        $user = User::findOne(['id' => $id]);

        $this->checkUserAccess($user);

        $user->status = User::STATUS_DISABLED;
        $user->save();

        return $this->redirect(['list']);
    }

    /**
     * Redirect to user profile
     *
     * @param int $id
     * @return \yii\base\Response the response
     * @throws HttpException
     */
    public function actionImpersonate($id)
    {
        $this->forcePostRequest();

        $user = User::findOne(['id' => $id]);

        $this->checkUserAccess($user);

        if (!Yii::$app->user->impersonate($user)) {
            throw new HttpException(403);
        }

        return $this->goHome();
    }

    /**
     * Export user list as csv or xlsx
     * @param string $format supported format by phpspreadsheet
     * @return \yii\web\Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\base\Exception
     */
    public function actionExport($format)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $exporter = new SpreadsheetExport([
            'dataProvider' => $dataProvider,
            'columns' => $this->collectExportColumns(),
            'resultConfig' => [
                'fileBaseName' => 'an602_user',
                'writerType' => $format,
            ],
        ]);

        return $exporter->export()->send();
    }

    /**
     * Return array with columns for data export
     * @return array
     */
    private function collectExportColumns()
    {
        $userColumns = [
            'id',
            'guid',
            'status',
            'username',
            'email',
            'auth_mode',
            [
                'class' => ArrayColumn::class,
                'attribute' => 'tags',
            ],
            'language',
            'time_zone',
            [
                'class' => DateTimeColumn::class,
                'attribute' => 'created_at',
            ],
            'created_by',
            [
                'class' => DateTimeColumn::class,
                'attribute' => 'updated_at',
            ],
            'updated_by',
            [
                'class' => DateTimeColumn::class,
                'attribute' => 'last_login',
            ],
            'authclient_id',
            'visibility',
        ];

        $profileColumns = (new Query())
            ->select(['CONCAT(\'profile.\', internal_name)'])
            ->from(ProfileField::tableName())
            ->orderBy(['profile_field_category_id' => SORT_ASC, 'sort_order' => SORT_ASC])
            ->column();

        return array_merge($userColumns, $profileColumns);
    }
}
