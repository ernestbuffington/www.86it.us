<?php

use an602\modules\content\widgets\WallCreateContentFormContainer;
use an602\modules\friendship\widgets\FriendsPanel;
use an602\modules\user\models\User;
use an602\modules\user\widgets\ProfileSidebar;
use an602\modules\user\widgets\StreamViewer;
use an602\modules\user\widgets\UserFollower;
use an602\modules\user\widgets\UserSpaces;
use an602\modules\user\widgets\UserTags;

/* @var $user User */
/* @var $isSingleContentRequest bool */
?>

<div data-stream-create-content="stream.wall.WallStream"<?php if ($isSingleContentRequest) : ?> style="display:none"<?php endif; ?>>
    <?= WallCreateContentFormContainer::widget(['contentContainer' => $user]); ?>
</div>

<?= StreamViewer::widget(['contentContainer' => $user]); ?>

<?php $this->beginBlock('sidebar'); ?>
<?=
ProfileSidebar::widget([
    'user' => $user,
    'widgets' => [
        [UserTags::class, ['user' => $user], ['sortOrder' => 10]],
        [UserSpaces::class, ['user' => $user], ['sortOrder' => 20]],
        [FriendsPanel::class, ['user' => $user], ['sortOrder' => 30]],
        [UserFollower::class, ['user' => $user], ['sortOrder' => 40]],
    ]
]);
?>
<?php $this->endBlock(); ?>
