<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\components\Module;
use an602\libs\Html;
use an602\modules\admin\widgets\ModuleActionButtons;
use an602\modules\admin\widgets\ModuleControls;
use an602\modules\admin\widgets\ModuleStatus;
use an602\modules\ui\icon\widgets\Icon;

/* @var $module Module */
/* @var $isFeaturedModule bool */
?>
<div class="card-panel">
    <?= ModuleStatus::widget(['module' => $module]) ?>
    <div class="card-header">
        <?= Html::img($module->getImage(), [
            'class' => 'media-object img-rounded',
            'data-src' => 'holder.js/94x94',
            'alt' => '94x94',
            'style' => 'width:94px;height:94px',
        ]) ?>
        <?= ModuleControls::widget(['module' => $module]) ?>
    </div>
    <div class="card-body">
        <div class="card-title"><?= $module->getName() . ($isFeaturedModule ? ' ' . Icon::get('star')->color('info') : '') ?></div>
        <div><?= $module->getVersion() ?></div>
        <div><?= $module->getDescription() ?></div>
    </div>
    <?= ModuleActionButtons::widget(['module' => $module]) ?>
</div>