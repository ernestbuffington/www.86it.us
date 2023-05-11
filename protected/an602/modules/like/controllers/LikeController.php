<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\like\controllers;

use an602\modules\like\Module;
use Yii;
use an602\modules\like\models\Like;
use an602\modules\user\widgets\UserListBox;
use an602\modules\content\components\ContentAddonController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Like Controller
 *
 * Handles requests by the like widgets. (e.g. like, unlike, show likes)
 *
 * @property Module $module
 * @since 0.5
 */
class LikeController extends ContentAddonController
{

    /**
     * @param $action
     * @return bool
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        if (!$this->module->isEnabled) {
            throw new HttpException(404, 'The like module not enabled!');
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \an602\components\behaviors\AccessControl::class,
                'guestAllowedActions' => ['show-likes']
            ]
        ];
    }

    /**
     * Creates a new like
     */
    public function actionLike()
    {
        if (!$this->module->canLike($this->parentContent)) {
            throw new ForbiddenHttpException();
        }

        $this->forcePostRequest();

        $like = Like::findOne(['object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::$app->user->id]);
        if ($like === null) {

            // Create Like Object
            $like = new Like([
                'object_model' => $this->contentModel,
                'object_id' => $this->contentId
            ]);
            $like->save();
        }

        return $this->actionShowLikes();
    }

    /**
     * Unlikes an item
     */
    public function actionUnlike()
    {
        $this->forcePostRequest();

        if (!Yii::$app->user->isGuest) {
            $like = Like::findOne(['object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::$app->user->id]);
            if ($like !== null) {
                $like->delete();
            }
        }

        return $this->actionShowLikes();
    }

    /**
     * Returns an JSON with current like informations about a target
     */
    public function actionShowLikes()
    {
        Yii::$app->response->format = 'json';

        // Some Meta Infos
        $currentUserLiked = false;

        $likes = Like::GetLikes($this->contentModel, $this->contentId);

        foreach ($likes as $like) {
            if ($like->user->id == Yii::$app->user->id) {
                $currentUserLiked = true;
            }
        }

        return [
            'currentUserLiked' => $currentUserLiked,
            'likeCounter' => count($likes)
        ];
    }

    /**
     * Returns a user list which contains all users who likes it
     */
    public function actionUserList()
    {

        $query = \an602\modules\user\models\User::find();
        $query->leftJoin('like', 'like.created_by=user.id');
        $query->where([
            'like.object_id' => $this->contentId,
            'like.object_model' => $this->contentModel,
        ]);
        $query->orderBy('like.created_at DESC');

        $title = Yii::t('LikeModule.base', "<strong>Users</strong> who like this");

        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }

}
