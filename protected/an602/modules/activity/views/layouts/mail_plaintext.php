<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

/* @var $this \yii\web\View */
/* @var $space Space */
/* @var $url string */
/* @var $contentContainer ContentContainerActiveRecord */
/* @var $html string */
/* @var $text string */
/* @var $originator User */

use an602\modules\content\components\ContentContainerActiveRecord;
?>

---

<?= $content ?>
<?php if (!empty($space)) : ?>
    (<?= Yii::t('ActivityModule.base', 'via') ?> <?= $space->displayName ?>)
<?php endif; ?>

<?php if ($url != '') : ?>
    <?= Yii::t('ActivityModule.base', 'See online:') ?> <?= urldecode($url) ?>
<?php endif; ?>
