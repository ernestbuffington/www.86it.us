<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\controllers;

use an602\components\Controller;
use an602\libs\ParameterEvent;
use \an602\modules\comment\Module as CommentModule;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\models\Content;
use an602\modules\post\models\Post;
use an602\modules\search\Module;
use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use an602\modules\user\models\Follow;
use an602\modules\user\models\User;
use an602\modules\user\permissions\CanMention;
use an602\modules\user\widgets\Image as UserImage;
use an602\modules\space\widgets\Image as SpaceImage;
use Yii;
use yii\web\HttpException;

/**
 * Controller used for mentioning (user/space) searches
 *
 * @since 1.4
 */
class MentioningController extends Controller
{
    /**
     * @event ParameterEvent an event raised after searching for space members on mentioning request from RichText editor on Post form, just before sending the results
     */
    public const EVENT_SPACE_MENTIONING = 'spaceMentioning';

    /**
     * @var Module $module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['login']
        ];
    }

    /**
     * Find all users and spaces on mentioning request from RichText editor
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $keyword = (string)Yii::$app->request->get('keyword');

        // Find users
        $users = User::find()
            ->available()
            ->search($keyword)
            ->limit($this->module->mentioningSearchBoxResultLimit)
            ->orderBy(['user.last_login' => SORT_DESC])
            ->all();

        $results = [];
        foreach ($users as $user) {
            if($user->permissionManager->can(CanMention::class)) {
                $results[] = $this->getUserResult($user);
            }
        }

        $results = $this->appendMentioningSpaceResults($keyword, $results);

        return $this->asJson($results);
    }

    /**
     * Find space members on mentioning request from RichText editor on Post form
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionSpace($id)
    {
        $keyword = (string)Yii::$app->request->get('keyword');

        $space = Space::findOne(['id' => (int) $id]);
        if (!$space || !(new Post($space))->content->canEdit()) {
            throw new HttpException(403, 'Access denied!');
        }

        // Find space members
        $users = Membership::getSpaceMembersQuery($space)
            ->available()
            ->search($keyword)
            ->limit($this->module->mentioningSearchBoxResultLimit)
            ->orderBy(['space_membership.last_visit' => SORT_DESC])
            ->all();

        $results = [];
        foreach ($users as $user) {
            $results[] = $this->getUserResult($user);
        }

        $results = $this->appendMentioningSpaceResults($keyword, $results);

        $evt = new ParameterEvent(['keyword' => $keyword, 'space' => $space, 'results' => $results]);
        ParameterEvent::trigger($this, static::EVENT_SPACE_MENTIONING, $evt);
        $results = $evt->parameters['results'];

        return $this->asJson($results);
    }

    /**
     * Find users followed to the Content on mentioning request from RichText editor on Comment form
     *
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionContent()
    {
        $contentId = (int)Yii::$app->request->get('id');
        $keyword = (string)Yii::$app->request->get('keyword');

        if (!($content = Content::findOne(['id' => $contentId]))) {
            throw new HttpException(403, 'Access denied!');
        }

        // Search all users/members on request with at least one char keyword:
        if ($keyword !== '') {
            if ($content->container instanceof Space && (new Post($content->container))->content->canEdit()) {
                return $this->actionSpace($content->container->id);
            } else {
                return $this->actionIndex();
            }
        }
        // Else search content followers only on initial call without provided keyword:

        /* @var CommentModule $commentModule */
        $commentModule = Yii::$app->getModule('comment');

        if (!($object = $content->getModel()) ||
            !$commentModule->canComment($object)) {
            throw new HttpException(403, 'Access denied!');
        }

        // Find users followed to the Content
        $users = Follow::getFollowersQuery($object, true)
            ->search($keyword)
            ->available()
            ->limit($this->module->mentioningSearchBoxResultLimit)
            ->orderBy(['user.last_login' => SORT_DESC])
            ->all();

        $results = [];
        foreach ($users as $user) {
            $results[] = $this->getUserResult($user);
        }

        return $this->asJson($results);
    }

    /**
     * Add space results if users number is not enough
     *
     * @param array $results
     * @return array
     */
    private function appendMentioningSpaceResults(string $keyword, array $results): array
    {
        $spaceNum = $this->module->mentioningSearchBoxResultLimit - count($results);

        if ($spaceNum <= 0) {
            // No need to add spaces because the list is already filled with max number of the results
            return $results;
        }

        $spaces = Space::find()
            ->visible()
            ->search($keyword)
            ->limit($spaceNum)
            ->all();
        foreach ($spaces as $space) {
            $results[] = $this->getSpaceResult($space);
        }

        return $results;
    }

    private function getContainerResult(ContentContainerActiveRecord $container, array $params): array
    {
        return array_merge([
            'guid' => $container->guid,
            'type' => null,
            'name' => $container->getDisplayName(),
            'image' => null,
            'link' => $container->getUrl(),
        ], $params);
    }

    private function getUserResult(User $user): array
    {
        return $this->getContainerResult($user, [
            'type' => 'u',
            'image' => UserImage::widget(['user' => $user, 'width' => 20]),
        ]);
    }

    private function getSpaceResult(Space $space): array
    {
        return $this->getContainerResult($space, [
            'type' => 's',
            'image' => SpaceImage::widget(['space' => $space, 'width' => 20]),
        ]);
    }

}
