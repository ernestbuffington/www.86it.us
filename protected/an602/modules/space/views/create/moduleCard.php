<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\components\Module;
use an602\libs\Helpers;
use an602\libs\Html;
use an602\modules\space\models\Space;
use an602\modules\space\widgets\ModuleActionButtons;

/* @var $module Module */
/* @var $contentContainer Space */
?>
<div class="card-panel">
    <div class="card-header">
        <?= Html::img($module->getImage(), [
            'class' => 'media-object img-rounded',
            'data-src' => 'holder.js/94x94',
            'alt' => '94x94',
            'style' => 'width:94px;height:94px',
        ]) ?>
    </div>
    <div class="card-body">
        <div class="card-title"><?= $module->getName() ?></div>
        <div><?= Helpers::truncateText($module->getContentContainerDescription($contentContainer), 75); ?></div>
    </div>
    <?= ModuleActionButtons::widget(['module' => $module, 'space' => $contentContainer]) ?>
</div>