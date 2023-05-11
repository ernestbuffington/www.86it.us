<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use an602\modules\admin\components\Controller;
use an602\modules\admin\permissions\ManageSettings;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\content\components\ContentContainerDefaultPermissionManager;
use an602\modules\content\models\ContentContainerDefaultPermission;
use an602\modules\content\models\ContentContainerPermission;
use an602\modules\content\models\ContentContainerSetting;
use an602\modules\user\models\User;
use an602\modules\user\Module;
use Yii;
use yii\db\Expression;
use yii\web\HttpException;

/**
 * User default permissions management
 *
 * @since 1.8
 */
class UserPermissionsController extends Controller
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
            ['permissions' => [ManageUsers::class]],
            ['permissions' => [ManageSettings::class], 'actions' => ['index']]
        ];
    }

    /**
     * Default User Permissions
     */
    public function actionIndex()
    {
        $defaultPermissionManager = new ContentContainerDefaultPermissionManager([
            'contentContainerClass' => User::class,
        ]);

        $groups = User::getUserGroups();

        $groupId = Yii::$app->request->get('groupId', User::USERGROUP_USER);
        if (!array_key_exists($groupId, $groups)) {
            throw new HttpException(500, 'Invalid group id given!');
        }

        // Handle permission state change
        if (Yii::$app->request->post('dropDownColumnSubmit')) {
            Yii::$app->response->format = 'json';
            $permission = $defaultPermissionManager->getById(Yii::$app->request->post('permissionId'), Yii::$app->request->post('moduleId'));
            if ($permission === null) {
                throw new HttpException(500, 'Could not find permission!');
            }
            $defaultPermissionManager->setGroupState($groupId, $permission, Yii::$app->request->post('state'));
            return [];
        }

        return $this->render('default', [
            'defaultPermissionManager' => $defaultPermissionManager,
            'groups' => $groups,
            'groupId' => $groupId,
        ]);
    }

    public function actionSwitchIndividualProfilePermissions()
    {
        $this->forcePostRequest();

        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        $oldState = (boolean)$userModule->settings->get('enableProfilePermissions', false);
        $newState = false;
        if (Yii::$app->request->post('isEnabled') === 'true') {
            $newState = true;
        }

        if ($oldState === true && $newState === false) {
            ContentContainerPermission::deleteAll('contentcontainer_id IN (SELECT contentcontainer_id FROM user)');
            $userModule->settings->set('enableProfilePermissions', false);
        } elseif ($oldState === false && $newState === true) {
            $userModule->settings->set('enableProfilePermissions', true);
        }

        return $this->asJson(['ok' => true, 'oldState' => $oldState, 'newState' => $newState]);
    }

}
