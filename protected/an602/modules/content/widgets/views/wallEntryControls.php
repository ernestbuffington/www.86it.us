<?php

use an602\libs\Html;
use an602\modules\content\widgets\LegacyWallEntryControlLink;
use an602\modules\ui\icon\widgets\Icon;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $menu \an602\modules\ui\menu\widgets\DropdownMenu */
/* @var $entries \an602\modules\ui\menu\MenuEntry[] */
/* @var $options [] */
?>

<?= Html::beginTag('ul', $options)?>
    <li class="dropdown ">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"
           aria-label="<?= Yii::t('base', 'Toggle stream entry menu'); ?>" aria-haspopup="true">
            <?= Icon::get('dropdownToggle') ?>
        </a>

        <ul class="dropdown-menu pull-right">
            <?php foreach ($entries as $entry) : ?>
                <?php if($entry instanceof LegacyWallEntryControlLink) : ?>
                    <?= $entry->render() ?>
                <?php else: ?>
                    <li>
                        <?= $entry->render() ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </li>
<?= Html::endTag('ul')?>
