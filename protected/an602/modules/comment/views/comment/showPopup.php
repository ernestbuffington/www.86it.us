<?php

use an602\libs\Html;
use an602\widgets\ModalDialog;
use an602\modules\comment\widgets\Form;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $object \an602\modules\content\components\ContentActiveRecord */

?>

<?php ModalDialog::begin(['header' => Yii::t('CommentModule.base', 'Comments')]) ?>
    <div class="modal-body comment-container comment-modal-body" style="margin-top:0">
        <div id="userlist-content">
            <div class="well well-small" id="comment_<?= $id ?>">
                <div class="comment" id="comments_area_<?= $id ?>">
                    <?= $output ?>
                </div>
                <?= Form::widget(['object' => $object]); ?>
            </div>
        </div>
    </div>
<?php ModalDialog::end() ?>

<script <?= Html::nonce() ?>>
    // scroll to top of list
    $(".comment-modal-body").animate({scrollTop: 0}, 200);

    <?php if(empty(trim($output))) : ?>
        $('#comment_<?= $id ?>').find('.comment_create hr').hide();
    <?php endif; ?>
</script>


