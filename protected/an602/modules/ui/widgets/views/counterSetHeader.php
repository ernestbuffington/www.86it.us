<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\libs\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $counters \an602\modules\ui\widgets\CounterSetItem[] */

?>

<div class="statistics pull-left">
    <?php foreach ($counters as $counter): ?>

        <?php if ($counter->hasLink()): ?>
            <?= Html::beginTag('a', array_merge(['href' => $counter->url], $counter->linkOptions)); ?>
        <?php endif; ?>

        <div class="pull-left entry">
            <span class="count"><?= $counter->getShortValue(); ?></span>
            <br>
            <span class="title"><?= $counter->label; ?></span>
        </div>

        <?php if ($counter->hasLink()): ?>
            <?= Html::endTag('a'); ?>
        <?php endif; ?>

    <?php endforeach; ?>
</div>
