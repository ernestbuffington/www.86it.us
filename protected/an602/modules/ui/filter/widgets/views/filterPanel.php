<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

use an602\modules\ui\filter\widgets\FilterBlock;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $span integer */
/* @var $blocks [] */

$colSpan = $span <= 4 ? 12 / $span : 6;

?>

<div class="filter-panel col-md-<?= $colSpan?>">
    <?php foreach ($blocks as $block): ?>
        <?= FilterBlock::widget($block)?>
    <?php endforeach; ?>
</div>
