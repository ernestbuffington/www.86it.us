<?php

use an602\libs\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $menu \an602\modules\ui\menu\widgets\DropdownMenu */
/* @var $entries \an602\modules\ui\menu\MenuEntry[] */
/* @var $options [] */
?>

<?= Html::beginTag('div', $options)?>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true">
        <?= $menu->label ?>
        <span class="caret"></span>
   </button>

    <ul class="dropdown-menu pull-right">
        <?php foreach ($entries as $entry) : ?>
            <li>
                <?= $entry->render() ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?= Html::endTag('div')?>
