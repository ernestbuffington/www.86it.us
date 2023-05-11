<?php

use an602\modules\space\widgets\Header;
use an602\modules\space\widgets\Menu;
use an602\modules\space\widgets\SpaceContent;
use an602\widgets\FooterMenu;

/**
 * @var \an602\modules\ui\view\components\View $this
 * @var \an602\modules\space\models\Space $space
 * @var string $content
 */

/** @var \an602\modules\content\components\ContentContainerController $context */
$context = $this->context;
$space = $context->contentContainer;

?>
<div class="container space-layout-container">
    <div class="row">
        <div class="col-md-12">
            <?= Header::widget(['space' => $space]); ?>
        </div>
    </div>
    <div class="row space-content">
        <div class="col-md-2 layout-nav-container">
            <?= Menu::widget(['space' => $space]); ?>
        </div>
        <div class="col-md-<?= ($this->hasSidebar()) ? '7' : '10' ?> layout-content-container">
            <?= SpaceContent::widget(['contentContainer' => $space, 'content' => $content]) ?>
        </div>
        <?php if ($this->hasSidebar()): ?>
            <div class="col-md-3 layout-sidebar-container">
                <?= $this->getSidebar() ?>
                <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_SIDEBAR]); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!$this->hasSidebar()): ?>
        <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_FULL_PAGE]); ?>
    <?php endif; ?>
</div>
