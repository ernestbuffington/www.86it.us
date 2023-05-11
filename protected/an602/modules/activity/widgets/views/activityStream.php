<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.an602.org/licences
 */

use an602\modules\activity\assets\ActivityAsset;
use an602\widgets\PanelMenu;
use yii\helpers\Html;

/* @var $this an602\modules\ui\view\components\View */
/* @var $streamUrl string */
/* @var $options array */

ActivityAsset::register($this);
?>
<div class="panel panel-default panel-activities" id="panel-activities">
    <?= PanelMenu::widget(['id' => 'panel-activities']) ?>
    <div class="panel-heading">
        <?= Yii::t('ActivityModule.base', '<strong>Latest</strong> activities') ?>
    </div>
    <?= Html::beginTag('div', $options) ?>
    <ul id="activityContents" class="media-list activities" data-stream-content></ul>
    <?= Html::endTag('div') ?>
</div>
