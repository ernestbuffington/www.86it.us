<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\comment\models\Comment;
use an602\modules\ui\view\components\View;
use an602\modules\user\widgets\Image as UserImage;
use an602\widgets\Button;

/* @var $this View */
/* @var $comment Comment */
/* @var $loadBlockedCommentUrl string */
?>

<div class="media comment-blocked-user" id="comment_<?= $comment->id; ?>"
     data-action-component="comment.Comment">

    <hr class="comment-separator">

    <?= UserImage::widget(['user' => $comment->user, 'width' => 25, 'htmlOptions' => ['class' => 'pull-left', 'data-contentcontainer-id' => $comment->user->contentcontainer_id]]); ?>
    <?= Yii::t('CommentModule.base', 'Comment of blocked user.') ?>
    <?= Button::asLink(Yii::t('CommentModule.base', 'Show'))->action('showBlocked', $loadBlockedCommentUrl)->xs()->cssClass('text-primary') ?>
</div>
