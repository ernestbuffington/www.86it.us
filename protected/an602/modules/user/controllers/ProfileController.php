<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\controllers;

use an602\modules\user\actions\ProfileStreamAction;
use an602\modules\user\Module;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\db\Expression;
use an602\modules\content\components\ContentContainerController;
use an602\modules\user\models\User;
use an602\modules\user\widgets\UserListBox;
use an602\modules\space\widgets\ListBox;
use an602\components\behaviors\AccessControl;
use an602\modules\user\permissions\ViewAboutPage;
use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;

/**
 * ProfileController is responsible for all user profiles.
 * Also the following functions are implemented here.
 *
 * @author Luke
 * @property Module $module
 * @since 0.5
 */
class ProfileController extends ContentContainerController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'guestAllowedActions' => ['index', 'stream', 'about', 'home']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'stream' => [
                'class' => ProfileStreamAction::class,
                'contentContainer' => $this->contentContainer
            ],
        ];
    }

    /**
     * User profile home
     *
     * @return string the response
     * @todo Allow change of default action
     */
    public function actionIndex()
    {
        if ($this->module->profileDefaultRoute !== null) {
            return $this->redirect(Url::to([$this->module->profileDefaultRoute, 'container' => $this->getUser()]));
        }

        return $this->actionHome();
    }

    public function actionHome()
    {
        if ($this->module->profileDisableStream) {
            return $this->redirect(Url::to(['/user/profile/about', 'container' => $this->getUser()]));
        }

        return $this->render('home', [
            'user' => $this->contentContainer,
            'isSingleContentRequest' => !empty(Yii::$app->request->getQueryParam('contentId')),
        ]);
    }

    public function actionAbout()
    {
        if (!$this->contentContainer->permissionManager->can(new ViewAboutPage())) {
            throw new HttpException(403, 'Forbidden');
        }

        return $this->render('about', ['user' => $this->contentContainer]);
    }

    public function actionFollow()
    {
        if (Yii::$app->getModule('user')->disableFollow) {
            throw new HttpException(403, Yii::t('ContentModule.base', 'This action is disabled!'));
        }

        $this->forcePostRequest();
        $this->getUser()->follow(Yii::$app->user->getIdentity());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }

        return $this->redirect($this->getUser()->getUrl());
    }

    public function actionUnfollow()
    {
        $this->forcePostRequest();
        $this->getUser()->unfollow();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }

        return $this->redirect($this->getUser()->getUrl());
    }

    public function actionFollowerList()
    {
        return $this->renderAjaxContent(UserListBox::widget([
            'query' => $this->getUser()->getFollowersQuery()->orderBy(['user_follow.id' => SORT_DESC]),
            'title' => Yii::t('UserModule.base', '<strong>Followers</strong>'),
        ]));
    }

    public function actionFollowedUsersList()
    {
        return $this->renderAjaxContent(UserListBox::widget([
            'query' => $this->getUser()->getFollowingQuery(User::find())->orderBy(['user_follow.id' => SORT_DESC]),
            'title' => Yii::t('UserModule.base', '<strong>Following</strong>'),
        ]));
    }

    public function actionSpaceMembershipList()
    {
        $query = Membership::getUserSpaceQuery($this->getUser());

        if (!$this->getUser()->isCurrentUser()) {
            $query->andWhere(['!=', 'space.visibility', Space::VISIBILITY_NONE]);
        }

        $title = Yii::t('UserModule.base', '<strong>Member</strong> in these spaces');
        return $this->renderAjaxContent(ListBox::widget(['query' => $query, 'title' => $title]));
    }

}
