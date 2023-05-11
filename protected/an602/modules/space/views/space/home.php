<?php

/**
 * @var \an602\modules\ui\view\components\View $this
 */

use an602\modules\activity\widgets\ActivityStreamViewer;
use an602\modules\content\widgets\WallCreateContentFormContainer;
use an602\modules\space\models\Space;
use an602\modules\space\Module;
use an602\modules\space\modules\manage\widgets\PendingApprovals;
use an602\modules\space\widgets\Members;
use an602\modules\space\widgets\Sidebar;
use an602\modules\stream\widgets\StreamViewer;

/* @var $space Space */
/* @var $canCreateEntries bool */
/* @var $isMember bool */
/* @var $isSingleContentRequest bool */

if ($canCreateEntries) {
    $emptyMessage = Yii::t('SpaceModule.base', '<b>This space is still empty!</b><br>Start by posting something here...');
} elseif ($isMember) {
    $emptyMessage = Yii::t('SpaceModule.base', '<b>This space is still empty!</b>');
} else {
    $emptyMessage = Yii::t('SpaceModule.base', '<b>You are not member of this space and there is no public content, yet!</b>');
}

/** @var Module $module */
$module = Yii::$app->getModule('space');
?>

<?php if ($canCreateEntries && !$isSingleContentRequest) : ?>
    <div data-stream-create-content="stream.wall.WallStream">
        <?= WallCreateContentFormContainer::widget(['contentContainer' => $space]); ?>
    </div>
<?php endif; ?>

<?= StreamViewer::widget([
    'contentContainer' => $space,
    'streamAction' => '/space/space/stream',
    'messageStreamEmpty' => $emptyMessage,
    'messageStreamEmptyCss' => $canCreateEntries ? 'placeholder-empty-stream' : '',
]); ?>

<?php
$this->beginBlock('sidebar');
$widgets = [];

if (!$space->getAdvancedSettings()->hideActivities) {
    $widgets[] = [ActivityStreamViewer::class, ['contentContainer' => $space], ['sortOrder' => 10]];
}

$widgets[] = [PendingApprovals::class, ['space' => $space], ['sortOrder' => 20]];

if (!$space->getAdvancedSettings()->hideMembers) {
    $widgets[] = [Members::class, ['space' => $space], ['sortOrder' => 30]];
}
?>
<?= Sidebar::widget(['space' => $space, 'widgets' => $widgets]); ?>
<?php $this->endBlock(); ?>
