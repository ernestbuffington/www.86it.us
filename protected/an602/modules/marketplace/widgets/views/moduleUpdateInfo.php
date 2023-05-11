<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\ui\icon\widgets\Icon;

/* @var string $class */
/* @var string $icon */
/* @var string $info */
/* @var string $link */
?>
<div class="row directory-filters-footer <?= $class ?>">
    <div class="col-md-8 col-xs-12">
        <?= Icon::get($icon, ['htmlOptions' => ['class' => 'filter-footer-icon']]) ?>
        <strong><?= $info ?></strong>
    </div>
    <div class="col-md-4 col-xs-12 text-right">
        <?= $link ?>
    </div>
</div>