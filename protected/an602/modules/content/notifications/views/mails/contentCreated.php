<?php

/* @var $this yii\web\View */
/* @var $viewable an602\modules\content\notifications\ContentCreated */
/* @var $url string */
/* @var $date string */
/* @var $isNew boolean */
/* @var $originator \an602\modules\user\models\User */
/* @var $source yii\db\ActiveRecord */
/* @var $contentContainer \an602\modules\content\components\ContentContainerActiveRecord */
/* @var $space an602\modules\space\models\Space */
/* @var $record \an602\modules\notification\models\Notification */
?>
<?php $this->beginContent('@notification/views/layouts/mail.php', $_params_); ?>

    <?= an602\widgets\mails\MailContentEntry::widget([
        'originator' => $originator,
        'receiver' => $record->user,
        'content' => $viewable->source,
        'date' => $date,
        'space' => $space
    ]) ?>

    <?= \an602\widgets\mails\MailButtonList::widget([
        'buttons' => [
            an602\widgets\mails\MailButton::widget(['url' => $url, 'text' => Yii::t('ContentModule.notifications', 'View Online')])
        ]
    ]) ?>

<?php $this->endContent();
