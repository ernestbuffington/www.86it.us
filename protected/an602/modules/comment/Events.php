<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment;

use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\widgets\WallEntryAddons;
use an602\modules\comment\models\Comment;
use an602\modules\search\events\SearchAttributesEvent;
use an602\modules\search\engine\Search;
use Yii;
use yii\base\Component;
use yii\base\Event;

/**
 * Events provides callbacks to handle events.
 *
 * @author luke
 */
class Events extends Component
{

    /**
     * On content deletion make sure to delete all its comments
     *
     * @param Event $event
     */
    public static function onContentDelete($event)
    {
        /** @var Comment|ContentActiveRecord $sender */
        $sender = $event->sender;

        foreach (Comment::find()->where(['object_model' => get_class($sender), 'object_id' => $sender->getPrimaryKey()])->all() as $comment) {
            $comment->delete();
        }
    }

    /**
     * On User delete, also delete all comments
     *
     * @param Event $event
     */
    public static function onUserDelete($event)
    {
        foreach (Comment::findAll(['created_by' => $event->sender->id]) as $comment) {
            $comment->delete();
        }

        return true;
    }

    /**
     * Callback to validate module database records.
     *
     * @param Event $event
     */
    public static function onIntegrityCheck($event)
    {
        $integrityController = $event->sender;
        $integrityController->showTestHeadline('Comment Module (' . Comment::find()->count() . ' entries)');

        // Loop over all comments
        foreach (Comment::find()->each() as $c) {

            // Check underlying record exists
            if ($c->source === null) {
                if ($integrityController->showFix('Deleting comment id ' . $c->id . ' without existing target!')) {
                    $c->delete();
                }
            }

            // User exists
            if ($c->user === null) {
                if ($integrityController->showFix('Deleting comment id ' . $c->id . ' without existing user!')) {
                    $c->delete();
                }
            }
        }
    }

    /**
     * On init of the WallEntryLinksWidget, attach the comment link widget.
     *
     * @param Event $event
     */
    public static function onWallEntryLinksInit($event)
    {
        if ($event->sender->object->content === null) {
            return;
        }

        /** @var Module $module */
        $module = Yii::$app->getModule('comment');

        if ($module->canComment($event->sender->object)) {
            $event->sender->addWidget(widgets\CommentLink::class, ['object' => $event->sender->object], ['sortOrder' => 10]);
        }
    }

    /**
     * On init of the WallEntryAddonWidget, attach the comment widget.
     *
     * @param Event $event
     */
    public static function onWallEntryAddonInit($event)
    {
        /* @var WallEntryAddons $wallEntryAddons */
        $wallEntryAddons = $event->sender;

        $wallEntryAddons->addWidget(widgets\Comments::class, [
            'object' => $wallEntryAddons->object,
            'renderOptions' => $wallEntryAddons->renderOptions,
        ], ['sortOrder' => 30]);
    }

    /**
     * Handles the SearchAttributesEvent and adds related comments
     *
     * @param SearchAttributesEvent $event
     * @since 1.2.3
     */
    public static function onSearchAttributes(SearchAttributesEvent $event)
    {
        if (!isset($event->attributes['comments'])) {
            $event->attributes['comments'] = [];
        }

        foreach (Comment::findAll(['object_model' => $event->record->className(), 'object_id' => $event->record->id]) as $comment) {
            /* @var $comment Comment */
            $event->attributes['comments'][$comment->id] = [
                'author' => ($comment->user !== null) ? $comment->user->displayName : '',
                'message' => $comment->message
            ];

            // Add comment related attributes (e.g. files)
            Event::trigger(Search::class, Search::EVENT_SEARCH_ATTRIBUTES, new SearchAttributesEvent($event->attributes['comments'][$comment->id], $comment));
        }
    }

}
