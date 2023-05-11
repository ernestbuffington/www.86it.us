<?php

use an602\libs\Html;
use an602\modules\dashboard\widgets\DashboardContent;
use an602\modules\dashboard\widgets\Sidebar;
use an602\modules\space\widgets\NewSpaces;
use an602\widgets\FooterMenu;

?>

<?= Html::beginContainer(); ?>
<div class="row">
    <div class="col-md-8 layout-content-container">
        <?= DashboardContent::widget(); ?>
    </div>
    <div class="col-md-4 layout-sidebar-container">
        <?= Sidebar::widget([
            'widgets' => [
                [
                    NewSpaces::class,
                    ['showMoreButton' => true],
                    ['sortOrder' => 400]
                ],
            ]
        ]);
        ?>
        <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_SIDEBAR]); ?>
    </div>
</div>
<?= Html::endContainer(); ?>
