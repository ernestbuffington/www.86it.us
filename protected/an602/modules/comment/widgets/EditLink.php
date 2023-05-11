<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\widgets;

use an602\libs\Html;
use an602\modules\comment\models\Comment;
use an602\modules\ui\icon\widgets\Icon;
use an602\modules\ui\menu\WidgetMenuEntry;
use Yii;
use yii\helpers\Url;

/**
 * EditLink for Comment
 *
 * @since 1.10
 */
class EditLink extends WidgetMenuEntry
{

    /**
     * @var Comment $comment
     */
    public $comment;

    /**
     * @inheritdoc
     */
    public function renderEntry($extraHtmlOptions = [])
    {
        $editUrl = Url::to(['/comment/comment/edit',
            'objectModel' => $this->comment->object_model,
            'objectId' => $this->comment->object_id,
            'id' => $this->comment->id,
        ]);

        $loadUrl = Url::to(['/comment/comment/load',
            'objectModel' => $this->comment->object_model,
            'objectId' => $this->comment->object_id,
            'id' => $this->comment->id,
        ]);

        return Html::a(Icon::get('edit') . ' ' . Yii::t('CommentModule.base', 'Edit'), '#',
                ['class' => 'comment-edit-link', 'data-action-click' => 'edit', 'data-action-url' => $editUrl]) .
            Html::a(Icon::get('edit') . ' ' . Yii::t('CommentModule.base', 'Cancel Edit'), '#',
                ['class' => 'comment-cancel-edit-link', 'data-action-click' => 'cancelEdit', 'data-action-url' => $loadUrl, 'style' => 'display:none']);
    }

}
