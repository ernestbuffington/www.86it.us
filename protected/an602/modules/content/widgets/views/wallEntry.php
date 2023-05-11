<?php

use an602\libs\Html;
use an602\modules\content\widgets\WallEntryAddons;
use an602\modules\content\widgets\WallEntryControls;
use an602\modules\content\widgets\WallEntryLabels;
use an602\modules\space\models\Space;
use an602\modules\space\widgets\Image as SpaceImage;
use an602\modules\user\widgets\Image as UserImage;
use an602\widgets\TimeAgo;
use yii\helpers\Url;

/* @var $object \an602\modules\content\models\Content */
/* @var $container \an602\modules\content\components\ContentContainerActiveRecord */
/* @var $renderControls boolean */
/* @var $wallEntryWidget string */
/* @var $user \an602\modules\user\models\User */
/* @var $showContentContainer \an602\modules\user\models\User */
?>


<div class="panel panel-default wall_<?= $object->getUniqueId(); ?>">
    <div class="panel-body">

        <div class="media">
            <!-- since v1.2 -->
            <div class="stream-entry-loader"></div>

            <!-- start: show wall entry options -->
            <?php if ($renderControls) : ?>
                <?= WallEntryControls::widget(['object' => $object, 'wallEntryWidget' => $wallEntryWidget]) ?>
            <?php endif; ?>
            <!-- end: show wall entry options -->

            <?=
            UserImage::widget([
                'user' => $user,
                'width' => 40,
                'htmlOptions' => ['class' => 'pull-left','data-contentcontainer-id' => $user->contentcontainer_id]
            ]);
            ?>

            <?php if ($showContentContainer && $container instanceof Space): ?>
                <?=
                SpaceImage::widget([
                    'space' => $container,
                    'width' => 20,
                    'htmlOptions' => ['class' => 'img-space'],
                    'link' => 'true',
                    'linkOptions' => ['class' => 'pull-left', 'data-contentcontainer-id' => $container->contentcontainer_id],
                ]);
                ?>
            <?php endif; ?>

            <div class="media-body">
                <div class="media-heading">
                    <?= Html::containerLink($user); ?>
                    <?php if ($container && $showContentContainer): ?>
                        <span class="viaLink">
                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                            <?= Html::containerLink($container); ?>
                        </span>
                    <?php endif; ?>

                    <div class="pull-right <?= ($renderControls) ? 'labels' : '' ?>">
                        <?= WallEntryLabels::widget(['object' => $object]); ?>
                    </div>
                </div>
                <div class="media-subheading">
                    <a href="<?= Url::to(['/content/perma', 'id' => $object->content->id], true) ?>">
                        <?= TimeAgo::widget(['timestamp' => $createdAt]); ?>
                    </a>
                    <?php if ($updatedAt !== null) : ?>
                        &middot;
                        <span class="tt"
                              title="<?= Yii::$app->formatter->asDateTime($updatedAt); ?>"><?= Yii::t('ContentModule.base', 'Updated'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <hr/>

            <div class="content" id="wall_content_<?= $object->getUniqueId(); ?>">
                <?= $content; ?>
            </div>

            <!-- wall-entry-addons class required since 1.2 -->
            <?php if ($renderAddons) : ?>
                <div class="stream-entry-addons clearfix">
                    <?= WallEntryAddons::widget($addonOptions); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
