<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\ui\menu\MenuLink;
use yii\helpers\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $entries MenuLink[] */
/* @var $options array */
/* @var $menu \an602\widgets\FooterMenu */

$i = 0;
?>

<center>
    <div class="text text-center powered footer-nav-email">
        <?php if (!empty($entries)): ?>
            <?php foreach ($entries as $k => $entry): ?>
                <?php if ($entry instanceof MenuLink): ?>
                    <?= Html::a($entry->getLabel(), $entry->getUrl(), $entry->getHtmlOptions([
                        'style' => 'text-decoration: none; color: ' . $this->theme->variable('text-color-soft2', '#aeaeae')
                    ])); ?>

                    <?php if (array_key_last($entries) !== $k): ?>
                        &nbsp;&middot;&nbsp;
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <br/>
            <br/>
        <?php endif; ?>
    </div>
</center>
