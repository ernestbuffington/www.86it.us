<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\widgets\WallCreateContentMenu;
use an602\modules\content\assets\ContentFormAsset;

/* @var $contentContainer ContentContainerActiveRecord */
/* @var $formClass string */

ContentFormAsset::register($this);
?>

<?= WallCreateContentMenu::widget(['contentContainer' => $contentContainer]) ?>

<?php if ($formClass) : ?>
    <?= $formClass::widget(['contentContainer' => $contentContainer]) ?>
<?php endif; ?>