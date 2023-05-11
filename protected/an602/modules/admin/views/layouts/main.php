<?php

use an602\widgets\FooterMenu;

/** @var $content string */
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?= \an602\modules\admin\widgets\AdminMenu::widget(); ?>
        </div>
        <div class="col-md-9">
            <?= $content; ?>
            <?= FooterMenu::widget(); ?>
        </div>
    </div>
</div>
