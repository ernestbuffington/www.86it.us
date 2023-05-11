<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\ui\widgets\DirectoryFilters;

/* @var $directoryFilters DirectoryFilters */
/* @var $filter string */
/* @var $data array */
?>

<div class="<?= $data['wrapperClass'] ?>">
    <?php if(isset($data['title'])) : ?>
        <div class="<?= $data['titleClass'] ?>"><?= $data['title'] ?></div>
    <?php endif; ?>
    <?= $directoryFilters->renderFilterInput($filter, $data) ?>
</div>