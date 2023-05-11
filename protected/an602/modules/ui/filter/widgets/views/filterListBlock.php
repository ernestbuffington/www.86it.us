<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

use an602\libs\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $title string */
/* @var $filters array */
/* @var $options array */

?>

<?= Html::beginTag('div', $options) ?>
    <strong><?= $title ?></strong>
    <ul class="filter-list">

        <?php foreach ($filters as $filter): ?>
            <li>
                <?= call_user_func($filter['class'].'::widget', $filter) ?>
            </li>
        <?php endforeach; ?>

    </ul>
<?= Html::endTag('div') ?>
