<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\widgets;

use an602\components\ActiveRecord;
use an602\components\Widget;
use an602\modules\comment\models\Comment as CommentModel;
use an602\modules\comment\Module;
use an602\modules\content\components\ContentActiveRecord;
use Yii;

/**
 * This widget is used to show a comment link inside the wall entry controls.
 *
 * @since 0.5
 */
class CommentLink extends Widget
{

    const MODE_INLINE = 'inline';
    const MODE_POPUP = 'popup';

    /**
     * @var CommentModel|ContentActiveRecord
     */
    public $object;

    /**
     * Mode
     *
     * inline: Show comments on the same page with CommentsWidget (default)
     * popup: Open comments popup, display only link
     *
     * @var string
     */
    public $mode;


    /**
     * @inheritDoc
     */
    public function run()
    {

        /** @var Module $module */
        $module = Yii::$app->getModule('comment');
        
        if (
            !$module->canComment($this->object)
            || (
                CommentModel::isSubComment($this->object)
                && !$module->canComment($this->object->content->getPolymorphicRelation())
            )
        ){
            return '';
        }

        if (empty($this->mode)) {
            $this->mode = self::MODE_INLINE;
        }

        return $this->render('link', [
            'id' => $this->object->getUniqueId(),
            'mode' => $this->mode,
            'objectModel' => get_class($this->object),
            'objectId' => $this->object->getPrimaryKey(),
            'commentCount' => CommentModel::GetCommentCount(get_class($this->object), $this->object->getPrimaryKey()),
            'isNestedComment' => ($this->object instanceof CommentModel),
            'comment' => $this->object,
            'module' => $module
        ]);
    }
}
