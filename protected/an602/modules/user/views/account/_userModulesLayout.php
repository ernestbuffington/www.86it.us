<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\user\widgets\AccountMenu;
use an602\widgets\FooterMenu;

/* @var string $content */
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?= AccountMenu::widget() ?>
        </div>
        <div class="col-md-9">
            <?= $content ?>
            <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_FULL_PAGE]); ?>
        </div>
    </div>
</div>
