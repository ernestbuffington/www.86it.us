<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\libs\Html;
use an602\modules\marketplace\assets\Assets;
use an602\modules\marketplace\models\Module;
use an602\modules\marketplace\widgets\ModuleUpdateActionButtons;
use an602\modules\ui\view\components\View;

/* @var View $this */
/* @var Module $module */

Assets::register($this);
?>
<div class="card-panel">
    <div class="card-header">
        <?= Html::img($module->image, [
            'class' => 'media-object img-rounded',
            'data-src' => 'holder.js/60x60',
            'alt' => '60x60',
            'style' => 'width:60px;height:60px',
        ]) ?>
    </div>
    <div class="card-body">
        <div class="card-title"><?= $module->name ?></div>
        <div><?= Yii::$app->moduleManager->getModule($module->id)->getVersion() ?> → <?= $module->latestCompatibleVersion ?></div>
    </div>
    <?= ModuleUpdateActionButtons::widget(['module' => $module]) ?>
</div>