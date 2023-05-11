<?php

use an602\libs\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $menu \an602\modules\ui\menu\widgets\DropdownMenu */
/* @var $entries \an602\modules\ui\menu\MenuEntry[] */
/* @var $options [] */
?>

<?= Html::beginTag('div', $options)?>
    <ul class="nav nav-tabs">
        <?php foreach ($entries as $entry): ?>
            <li <?php if ($entry->getIsActive()): ?>class="active"<?php endif; ?>>
                <?= $entry->render() ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?= Html::endTag('div')?>
