<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\controllers;

use Yii;
use yii\web\HttpException;
use an602\modules\content\models\Content;
use an602\modules\space\modules\manage\jobs\ChangeContentVisibilityJob;
use an602\modules\space\modules\manage\components\Controller;
use an602\modules\space\models\Space;
use an602\modules\space\permissions\CreatePrivateSpace;
use an602\modules\space\permissions\CreatePublicSpace;
use an602\modules\user\helpers\AuthHelper;

/**
 * SecurityController
 *
 * @since 1.1
 * @author Luke
 */
class SecurityController extends Controller
{
    public function actionIndex()
    {
        $space = $this->contentContainer;
        $space->scenario = Space::SCENARIO_SECURITY_SETTINGS;

        if ($space->load(Yii::$app->request->post())) {
            $visibilityChangedToPrivate = $space->isAttributeChanged('visibility') && $space->visibility == Space::VISIBILITY_NONE;
            if ($space->save()) {
                if ($visibilityChangedToPrivate) {
                    Yii::$app->queue->push(new ChangeContentVisibilityJob([
                        'contentContainerId' => $space->contentcontainer_id,
                        'visibility' => Content::VISIBILITY_PRIVATE,
                    ]));
                }

                $this->view->saved();

                return $this->redirect($space->createUrl('index'));
            } elseif (Yii::$app->request->post()) {
                $this->view->error(Yii::t('SpaceModule.base', 'Settings could not be saved!'));
            }
        }

        $visibilities = [];
        if ($space->visibility === Space::VISIBILITY_NONE ||
            Yii::$app->user->permissionManager->can(new CreatePrivateSpace)) {
            $visibilities[Space::VISIBILITY_NONE] = Yii::t('SpaceModule.base', 'Private (Invisible)');
        }
        $canCreatePublicSpace = Yii::$app->user->permissionManager->can(new CreatePublicSpace);
        if ($space->visibility === Space::VISIBILITY_REGISTERED_ONLY ||
            $canCreatePublicSpace) {
            $visibilities[Space::VISIBILITY_REGISTERED_ONLY] = Yii::t('SpaceModule.base', 'Public (Registered users only)');
        }
        if ($space->visibility === Space::VISIBILITY_ALL ||
            ($canCreatePublicSpace && AuthHelper::isGuestAccessEnabled())) {
            $visibilities[Space::VISIBILITY_ALL] = Yii::t('SpaceModule.base', 'Visible for all (members and guests)');
        }

        return $this->render('index', ['model' => $space, 'visibilities' => $visibilities]);
    }

    /**
     * Shows space permessions
     */
    public function actionPermissions()
    {
        $space = $this->getSpace();

        $groups = $space->getUserGroups();
        $groupId = Yii::$app->request->get('groupId', Space::USERGROUP_MEMBER);
        if (!array_key_exists($groupId, $groups)) {
            throw new HttpException(500, 'Invalid group id given!');
        }

        // Handle permission state change
        if (Yii::$app->request->post('dropDownColumnSubmit')) {
            Yii::$app->response->format = 'json';
            $permission = $space->permissionManager->getById(Yii::$app->request->post('permissionId'), Yii::$app->request->post('moduleId'));
            if ($permission === null) {
                throw new HttpException(500, 'Could not find permission!');
            }
            $space->permissionManager->setGroupState($groupId, $permission, Yii::$app->request->post('state'));
            return [];
        }

        return $this->render('permissions', [
                    'space' => $space,
                    'groups' => $groups,
                    'groupId' => $groupId
        ]);
    }
}
