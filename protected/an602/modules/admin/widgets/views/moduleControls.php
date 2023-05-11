<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\libs\Html;
use an602\modules\ui\icon\widgets\Icon;
use an602\modules\ui\menu\MenuEntry;

/* @var MenuEntry[] $entries */
/* @var array $options */
?>

<?= Html::beginTag('ul', $options)?>
    <li class="dropdown ">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"
           aria-label="<?= Yii::t('base', 'Toggle stream entry menu'); ?>" aria-haspopup="true">
            <?= Icon::get('dropdownToggle') ?>
        </a>

        <ul class="dropdown-menu pull-right">
            <?php foreach ($entries as $entry) : ?>
                <li>
                    <?= $entry->render() ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
<?= Html::endTag('ul')?>
