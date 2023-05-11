<?php $this->beginContent('@notification/views/layouts/mail.php', $_params_); ?>
<?= $html; ?>
<br />
<br />
<?=
\an602\widgets\mails\MailButtonList::widget([
    'buttons' => [
        an602\widgets\mails\MailButton::widget(['url' => $url, 'text' => Yii::t('ContentModule.notifications', 'View Online')])
    ]
])
?>
<?php $this->endContent(); ?>