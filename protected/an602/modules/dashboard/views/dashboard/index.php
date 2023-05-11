<?php
/**
 * @var \an602\modules\user\models\User $contentContainer
 * @var bool $showProfilePostForm
 */

use an602\modules\activity\widgets\ActivityStreamViewer;
use an602\modules\dashboard\widgets\DashboardContent;
use an602\modules\dashboard\widgets\Sidebar;
use an602\widgets\FooterMenu;
use an602\libs\Html;

?>

<?= Html::beginContainer() ?>
<div class="row">
    <div class="col-md-8 layout-content-container">
        <?= DashboardContent::widget([
            'contentContainer' => $contentContainer,
            'showProfilePostForm' => $showProfilePostForm
        ]);
        ?>
    </div>
    <div class="col-md-4 layout-sidebar-container">
        <?= Sidebar::widget([
            'widgets' => [
                [
                    ActivityStreamViewer::class,
                    ['streamAction' => '/dashboard/dashboard/activity-stream'],
                    ['sortOrder' => 150]
                ]
            ]
        ]);
        ?>
        <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_SIDEBAR]); ?>
    </div>
</div>
<?= Html::endContainer() ?>
