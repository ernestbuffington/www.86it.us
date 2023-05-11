<?php

use an602\libs\Html;
use an602\modules\comment\models\Comment as CommentModel;
use an602\modules\comment\widgets\Comment;
use an602\modules\comment\widgets\Form;
use an602\modules\comment\widgets\ShowMore;
use an602\modules\content\components\ContentActiveRecord;

/* @var $object ContentActiveRecord|CommentModel */
/* @var $comments CommentModel[] */
/* @var $currentCommentId int */
/* @var $id string unqiue object id */
?>
<div class="well well-small comment-container" style="display:none;" id="comment_<?= $id; ?>">
    <div class="comment <?php if (Yii::$app->user->isGuest): ?>guest-mode<?php endif; ?>"
         id="comments_area_<?= $id; ?>">

        <?= ShowMore::widget([
            'object' => $object,
            'commentId' => isset($comments[0]) ? $comments[0]->id : null,
            'type' => ShowMore::TYPE_PREVIOUS,
        ]); ?>

        <?php foreach ($comments as $comment) : ?>
            <?= Comment::widget([
                'comment' => $comment,
                'additionalClass' => ($currentCommentId == $comment->id ? 'comment-current' : ''),
            ]); ?>
        <?php endforeach; ?>

        <?php if ($currentCommentId && count($comments) > 1) : ?>
            <?= ShowMore::widget([
                'object' => $object,
                'commentId' => $comments[count($comments)-1]->id,
                'type' => ShowMore::TYPE_NEXT,
            ]); ?>
        <?php endif; ?>
    </div>

    <?= Form::widget(['object' => $object]); ?>
</div>

<script <?= Html::nonce() ?>>
<?php if (count($comments) != 0): ?>
    // make comments visible at this point to fixing autoresizing issue for textareas in Firefox
    $('#comment_<?= $id; ?>').show();
<?php endif; ?>
<?php if (!empty($currentCommentId)) : ?>
    $('#comment_<?= $currentCommentId ?>').get(0).scrollIntoView();
<?php endif; ?>
</script>
