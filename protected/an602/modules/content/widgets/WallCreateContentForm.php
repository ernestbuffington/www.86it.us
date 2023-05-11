<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\modules\content\permissions\CreatePublicContent;
use an602\modules\stream\actions\StreamEntryResponse;
use an602\modules\topic\models\Topic;
use an602\modules\ui\form\widgets\ActiveForm;
use an602\components\Widget;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;
use an602\modules\content\models\Content;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\components\ContentActiveRecord;
use Yii;
use yii\web\HttpException;

/**
 * WallCreateContentForm is the base widget to create  "quick" create content forms above Stream/Wall.
 *
 * @author luke
 */
abstract class WallCreateContentForm extends Widget
{

    /**
     * @var string form submit route/url (required)
     */
    public $submitUrl;

    /**
     * @var ContentContainerActiveRecord this content will belong to
     */
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!($this->contentContainer instanceof ContentContainerActiveRecord)) {
            throw new HttpException(500, 'No Content Container given!');
        }

        parent::init();
    }

    /**
     * Returns the custom form implementation.
     *
     * @return string
     */
    public function renderForm()
    {
        return '';
    }

    /**
     * Returns the custom form implementation.
     *
     * @param ActiveForm $form
     * @return string
     */
    public function renderActiveForm(ActiveForm $form): string
    {
        return $this->renderForm();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->contentContainer->visibility !== Space::VISIBILITY_NONE && $this->contentContainer->can(CreatePublicContent::class)) {
            $defaultVisibility = $this->contentContainer->getDefaultContentVisibility();
        } else {
            $defaultVisibility = Content::VISIBILITY_PRIVATE;
        }

        return $this->render('@an602/modules/content/widgets/views/wallCreateContentForm', [
            'wallCreateContentForm' => $this,
            'contentContainer' => $this->contentContainer,
            'defaultVisibility' => $defaultVisibility,
        ]);
    }

    /**
     * Creates the given ContentActiveRecord based on given submitted form information.
     *
     * - Automatically assigns ContentContainer
     * - Access Check
     * - User Notification / File Uploads
     * - Reloads Wall after successfull creation or returns error json
     *
     * [See guide section](guide:dev-module-stream.md#CreateContentForm)
     *
     * @param ContentActiveRecord $record
     * @return array json
     */
    public static function create(ContentActiveRecord $record, ContentContainerActiveRecord $contentContainer = null)
    {
        Yii::$app->response->format = 'json';

        $visibility = Yii::$app->request->post('visibility', Content::VISIBILITY_PRIVATE);
        if ($visibility == Content::VISIBILITY_PUBLIC && !$contentContainer->can(CreatePublicContent::class)) {
            $visibility = Content::VISIBILITY_PRIVATE;
        }

        $record->content->visibility = $visibility;
        $record->content->container = $contentContainer;
        $record->content->setState(Yii::$app->request->post('state'), [
            'scheduled_at' => Yii::$app->request->post('scheduledDate')
        ]);

        // Handle Notify User Features of ContentFormWidget
        // ToDo: Check permissions of user guids
        $userGuids = Yii::$app->request->post('notifyUserInput');
        if (!empty($userGuids)) {
            foreach ($userGuids as $guid) {
                $user = User::findOne(['guid' => trim($guid)]);
                if ($user) {
                    $record->content->notifyUsersOfNewContent[] = $user;
                }
            }
        }

        if ($record->save()) {
            $topics = Yii::$app->request->post('postTopicInput');
            if (!empty($topics)) {
                Topic::attach($record->content, $topics);
            }

            $record->fileManager->attach(Yii::$app->request->post('fileList'));
            return StreamEntryResponse::getAsArray($record->content);
        }

        return ['errors' => $record->getErrors()];
    }

}
