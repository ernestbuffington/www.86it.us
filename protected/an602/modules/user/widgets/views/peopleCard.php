<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\libs\Html;
use an602\modules\user\models\User;
use an602\modules\user\widgets\PeopleActionButtons;
use an602\modules\user\widgets\Image;
use an602\modules\user\widgets\PeopleDetails;
use an602\modules\user\widgets\PeopleIcons;
use an602\modules\user\widgets\PeopleTagList;
use yii\web\View;

/* @var $this View */
/* @var $user User */
?>

<div class="card-panel">
    <div
        class="card-bg-image"<?php if ($user->getProfileBannerImage()->hasImage()) : ?> style="background-image: url('<?= $user->getProfileBannerImage()->getUrl() ?>')"<?php endif; ?>></div>
    <div class="card-header">
        <?= Image::widget([
            'user' => $user,
            'htmlOptions' => ['class' => 'card-image-wrapper'],
            'linkOptions' => ['data-contentcontainer-id' => $user->contentcontainer_id, 'class' => 'card-image-link'],
            'width' => 94,
        ]); ?>
        <?php /*<div class="card-icons">
            <?= PeopleIcons::widget(['user' => $user]); ?>
        </div> */ ?>
    </div>
    <div class="card-body">
        <strong class="card-title"><?= Html::containerLink($user); ?></strong>
        <?php if (!empty($user->displayNameSub)) : ?>
            <div><?= Html::encode($user->displayNameSub); ?></div>
        <?php endif; ?>
        <?= PeopleDetails::widget([
            'user' => $user,
            'template' => '<div class="card-details">{lines}</div>',
            'separator' => '<br>',
        ]); ?>
        <?= PeopleTagList::widget([
            'user' => $user,
            'template' => '<div class="card-tags">{tags}</div>',
        ]); ?>
    </div>
    <?= PeopleActionButtons::widget([
        'user' => $user,
        'template' => '<div class="card-footer">{buttons}</div>',
    ]); ?>
</div>
