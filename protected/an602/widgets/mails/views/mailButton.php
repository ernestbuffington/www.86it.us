<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

/* @var $color string */
/* @var $text string */
/* @var $url string */

?>
<td width="auto"  align="center" valign="middle" height="32" 
    style="background-color:<?= $color ?>; border-radius:5px; background-clip: padding-box;font-size:14px; font-family:Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;font-weight: 600; padding-left:30px; padding-right:30px; padding-top: 5px; padding-bottom: 5px;">                   
    <span>
        <a href="<?= $url; ?>" style="text-decoration: none; color: <?= Yii::$app->view->theme->variable('button-text-color', '#fff'); ?>; font-weight: 300;">
            <?= $text ?>
        </a>
    </span>
</td>
