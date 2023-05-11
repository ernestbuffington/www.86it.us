<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\controllers;

use an602\components\Controller;
use an602\modules\friendship\models\Friendship;
use an602\modules\friendship\Module;
use an602\modules\friendship\widgets\FriendshipButton;
use an602\modules\user\models\User;
use Yii;
use yii\web\HttpException;

/**
 * Membership Handling Controller
 *
 * @property Module $module
 * @author luke
 */
class RequestController extends Controller
{

    /**
     * @inheritdoc
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        if (!$this->module->getIsEnabled()) {
            throw new HttpException(404, 'Friendship system is not enabled!');
        }

        return parent::beforeAction($action);
    }


    /**
     * Adds or Approves Friendship Request
     * @throws HttpException
     */
    public function actionAdd()
    {
        $friend = $this->getFriendUser();

        Friendship::add(Yii::$app->user->getIdentity(), $friend);

        return $this->getActionResult($friend);
    }

    /**
     * Declines or Deletes Friendship
     * @throws HttpException
     */
    public function actionDelete()
    {
        $friend = $this->getFriendUser();

        Friendship::cancel(Yii::$app->user->getIdentity(), $friend);

        return $this->getActionResult($friend);
    }

    /**
     * Get friend User from request
     *
     * @return User
     * @throws HttpException
     */
    protected function getFriendUser(): User
    {
        $this->forcePostRequest();

        $friend = User::findOne(['id' => Yii::$app->request->get('userId')]);

        if ($friend === null) {
            throw new HttpException(404, 'User not found!');
        }

        return $friend;
    }

    /**
     * Get result for the friendship actions
     *
     * @param User $user
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws \Exception
     */
    protected function getActionResult(User $user)
    {
        if ($this->request->isAjax) {
            $options = $this->request->post('options', []);

            // Show/Hide the "Follow"/"Unfollow" buttons depending on updated friendship state after AJAX action
            $options['cancelFriendRequest']['attrs']['data-show-buttons'] = $user->isFollowedByUser() ? '.unfollowButton' : '.followButton';
            $options['cancelFriendRequest']['attrs']['data-hide-buttons'] = $user->isFollowedByUser() ? '.followButton' : '.unfollowButton';

            return FriendshipButton::widget([
                'user' => $user,
                'options' => $options,
            ]);
        }

        return $this->redirect($this->request->getReferrer());
    }

}
