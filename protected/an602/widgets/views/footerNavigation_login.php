<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use yii\helpers\Html;
use an602\widgets\PoweredBy;
use an602\modules\ui\menu\MenuLink;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $entries MenuLink[] */
/* @var $options array */
/* @var $menu \an602\widgets\FooterMenu */

?>

<div class="text text-center powered">
    <?php if (!empty($entries)): ?>
        <div class="footer-nav footer-nav-login">
            <?php foreach ($entries as $k => $entry): ?>
                <?php if ($entry instanceof MenuLink): ?>
                    <?= Html::a($entry->getLabel(), $entry->getUrl(), $entry->getHtmlOptions(['data-pjax-prevent' => true])); ?>
                <?php endif; ?>

                <?php if (array_key_last($entries) !== $k): ?>
                    &nbsp;&middot;&nbsp;
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br/>
    <?= PoweredBy::widget(); ?>
</div>
