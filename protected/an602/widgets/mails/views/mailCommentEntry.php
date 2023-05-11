<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */
?>
<table width="100%" style="background-color:<?= Yii::$app->view->theme->variable('background-color-secondary') ?>;border-radius:4px" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td style="padding:0 10px;">
            <?= an602\widgets\mails\MailContentEntry::widget([
                'originator' => $originator,
                'receiver' => $receiver,
                'content' => $comment,
                'date' => $date,
                'space' => $space,
                'isComment' => true
            ]); ?>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
</table>