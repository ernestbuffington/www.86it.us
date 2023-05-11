<?php

use an602\widgets\FooterMenu;

?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php
            echo \an602\modules\user\widgets\AccountMenu::widget(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <?php echo $content; ?>
            </div>
            <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_FULL_PAGE]); ?>
        </div>
    </div>
</div>
