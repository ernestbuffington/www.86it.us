<?php
/* @var $this yii\web\View */
/* @var $viewable an602\modules\comment\notifications\NewComment */
/* @var $url string */
/* @var $date string */
/* @var $isNew boolean */
/* @var $isNew boolean */
/* @var $originator \an602\modules\user\models\User */
/* @var $source yii\db\ActiveRecord */
/* @var $contentContainer \an602\modules\content\components\ContentContainerActiveRecord */
/* @var $space an602\modules\space\models\Space */
/* @var $record \an602\modules\notification\models\Notification */
/* @var $html string */
/* @var $text string */
?>
<?php $this->beginContent('@notification/views/layouts/mail.php', $_params_); ?>

<?php $comment = $viewable->source; ?>
<?php $contentRecord = $viewable->getCommentedRecord() ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td>
            <?=
            an602\widgets\mails\MailCommentEntry::widget([
                'originator' => $originator,
                'receiver' => $record->user,
                'comment' => $comment,
                'date' => $comment->updated_at,
                'space' => $space
            ]);
            ?>
        </td>
    </tr>
     <tr>
        <td height="20"></td>
    </tr>
     <tr>
        <td>
            <?=
            an602\widgets\mails\MailHeadline::widget([
                'level' => 3,
                'text' => $contentRecord->getContentName().':',
                'style' => 'text-transform:capitalize;'
            ])
            ?>
        </td>
    </tr>
    <tr>
        <td style="padding:10px; border:1px solid <?= Yii::$app->view->theme->variable('background-color-secondary') ?>; border-radius:4px;">
            <?=
            an602\widgets\mails\MailContentEntry::widget([
                'originator' => $contentRecord->owner,
                'receiver' => $record->user,
                'content' => $contentRecord,
                'date' => $contentRecord->content->updated_at,
                'space' => $space
            ]);
            ?>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td>
            <?=
            an602\widgets\mails\MailButtonList::widget(['buttons' => [
                an602\widgets\mails\MailButton::widget([
                    'url' => $url,
                    'text' => Yii::t('CommentModule.notification', 'View Online')
                ])
            ]]);
            ?>
        </td>
    </tr>
</table>
<?php $this->endContent(); ?>