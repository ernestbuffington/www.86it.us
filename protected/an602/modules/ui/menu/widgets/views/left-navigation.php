<?php

use an602\libs\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $menu \an602\modules\ui\menu\widgets\LeftNavigation */
/* @var $entries \an602\modules\ui\menu\MenuEntry[] */
/* @var $options [] */
?>

<?= Html::beginTag('div', $options) ?>
    <?php if (!empty($menu->panelTitle)) : ?>
        <div class="panel-heading"><?= $menu->panelTitle; ?></div>
    <?php endif; ?>

    <div class="list-group">
        <?php foreach ($entries as $entry): ?>
            <?= $entry->render(['class' => 'list-group-item']) ?>
        <?php endforeach; ?>
    </div>
<?= Html::endTag('div') ?>
