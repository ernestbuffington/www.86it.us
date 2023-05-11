<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

use an602\modules\stream\widgets\WallStreamFilterNavigation;
use an602\modules\ui\filter\widgets\FilterPanel;
use an602\widgets\Button;
use yii\helpers\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $panels [] */
/* @var $options [] */

$panelColumn1Blocks = isset($panels[WallStreamFilterNavigation::PANEL_COLUMN_1]) ? $panels[WallStreamFilterNavigation::PANEL_COLUMN_1] : null;
$panelColumn2Blocks = isset($panels[WallStreamFilterNavigation::PANEL_COLUMN_2]) ? $panels[WallStreamFilterNavigation::PANEL_COLUMN_2] : null;
$panelColumn3Blocks = isset($panels[WallStreamFilterNavigation::PANEL_COLUMN_3]) ? $panels[WallStreamFilterNavigation::PANEL_COLUMN_3] : null;
$panelColumn4Blocks = isset($panels[WallStreamFilterNavigation::PANEL_COLUMN_4]) ? $panels[WallStreamFilterNavigation::PANEL_COLUMN_4] : null;

?>

<?= Html::beginTag('div', $options) ?>

    <div class="wall-stream-filter-root nav-tabs">
        <div class="wall-stream-filter-head clearfix">
            <div class="wall-stream-filter-bar"></div>
            <?= Button::asLink(Yii::t('ContentModule.base', 'Filter') . '<b class="caret"></b>')
                ->cssClass('wall-stream-filter-toggle')->icon('fa-filter')->sm()->style('pa') ?>
        </div>
        <div class="wall-stream-filter-body" style="display:none">
            <div class="filter-root">
                <div class="row">
                    <?= FilterPanel::widget(['blocks' => $panelColumn1Blocks, 'span' => count($panels)])?>
                    <?= FilterPanel::widget(['blocks' => $panelColumn2Blocks, 'span' => count($panels)])?>
                    <?= FilterPanel::widget(['blocks' => $panelColumn3Blocks, 'span' => count($panels)])?>
                </div>
            </div>
        </div>
    </div>

<?= Html::endTag('div') ?>
