<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\libs\Html;
use an602\modules\space\models\Space;
use an602\modules\space\widgets\Image;
use an602\modules\space\widgets\SpaceDirectoryActionButtons;
use an602\modules\space\widgets\SpaceDirectoryIcons;
use an602\modules\space\widgets\SpaceDirectoryStatus;
use an602\modules\space\widgets\SpaceDirectoryTagList;
use yii\web\View;

/* @var $this View */
/* @var $space Space */
?>

<div class="card-panel<?php if ($space->isArchived()) : ?> card-archived<?php endif; ?>">
    <div class="card-bg-image"<?php if ($space->getProfileBannerImage()->hasImage()) : ?> style="background-image: url('<?= $space->getProfileBannerImage()->getUrl() ?>')"<?php endif; ?>></div>
    <div class="card-header">
        <?= Image::widget([
            'space' => $space,
            'link' => true,
            'linkOptions' => ['data-contentcontainer-id' => $space->contentcontainer_id, 'class' => 'card-image-link'],
            'width' => 94,
        ]); ?>
        <?= SpaceDirectoryStatus::widget(['space' => $space]); ?>
        <div class="card-icons">
            <?= SpaceDirectoryIcons::widget(['space' => $space]); ?>
        </div>
    </div>
    <div class="card-body">
        <strong class="card-title"><?= Html::containerLink($space); ?></strong>
        <?php if (trim($space->description) !== '') : ?>
            <div class="card-details"><?= Html::encode($space->description); ?></div>
        <?php endif; ?>
        <?= SpaceDirectoryTagList::widget([
            'space' => $space,
            'template' => '<div class="card-tags">{tags}</div>',
        ]); ?>
    </div>
    <?= SpaceDirectoryActionButtons::widget([
        'space' => $space,
        'template' => '<div class="card-footer">{buttons}</div>',
    ]); ?>
</div>