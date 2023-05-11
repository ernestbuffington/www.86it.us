<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */
/* @var $this yii\web\View */
/* @var $viewable an602\modules\like\notifications\NewLike */
/* @var $url string */
/* @var $date string */
/* @var $isNew boolean */
/* @var $originator \an602\modules\user\models\User */
/* @var $source yii\db\ActiveRecord */
/* @var $contentContainer \an602\modules\content\components\ContentContainerActiveRecord */
/* @var $space an602\modules\space\models\Space */
/* @var $record \an602\modules\notification\models\Notification */

$likedRecord = $viewable->getLikedRecord();
?>

<?php $this->beginContent('@notification/views/layouts/mail.php', $_params_); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td>
            <?=
            an602\widgets\mails\MailContentEntry::widget([
                'receiver' => $record->user,
                'content' => $likedRecord,
                'date' => $date,
                'space' => $space
            ])
            ?>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td>
            <?=
            \an602\widgets\mails\MailButtonList::widget([
                'buttons' => [
                    an602\widgets\mails\MailButton::widget(['url' => $url, 'text' => Yii::t('LikeModule.notifications', 'View Online')])
                ]
            ])
            ?>
        </td>
    </tr>
</table>
<?php
$this->endContent();
