<?php

use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use an602\modules\space\widgets\Image as SpaceImage;
use an602\modules\user\widgets\Image as UserImage;
use yii\helpers\Html;
use an602\modules\ui\content\assets\UiImageSetAsset;

UiImageSetAsset::register($this);
?>
<div class="ui-imageset-wrapper">
    <div class="ui-imageset-items" style="padding-right: <?= $options['width'] ?>px">
        <?php
        foreach ($visibleItems as $item) {
            if ($item instanceof Space) {
                echo SpaceImage::widget(array_merge($options, ['space' => $item]));
            } else if ($item instanceof User) {
                unset($options['acronymCount']);
                echo UserImage::widget(array_merge($options, ['user' => $item]));
            }
        }
        ?>
        <?php if (count($hiddenItems) > 0) : ?>
            <div class="ui-imageset-show-more tt img-rounded"
                 style="width: <?= $options['width'] ?>px; height: <?= $options['height'] ?>px;"
                 data-toggle="tooltip"
                 data-placement="top"
                 data-original-title="Show more"><?= count($hiddenItems) ?>+
            </div>
            <div class="ui-imageset-hidden-items">
                <?php
                foreach ($hiddenItems as $item) : ?>
                    <div class="hidden-item">
                        <?php
                        if ($item instanceof Space) {
                            echo SpaceImage::widget(array_merge($options, [
                                'space' => $item,
                                'width' => $hiddenItemsOptions['width'],
                                'height' => $hiddenItemsOptions['height'],
                                'showTooltip' => false
                            ]));
                        } else if ($item instanceof User) {
                            echo UserImage::widget(array_merge($options, [
                                'user' => $item,
                                'width' => $hiddenItemsOptions['width'],
                                'height' => $hiddenItemsOptions['height'],
                                'showTooltip' => false
                            ]));
                        }
                        if ($options['link']) {
                            echo '<span class="display-name-link">';
                            echo Html::a(Html::encode($item->getDisplayName()), $item->getUrl(), $options['linkOptions']);
                            echo '</span>';
                        } else {
                            echo '<span class="display-name-text">';
                            echo Html::tag('span', Html::encode($item->getDisplayName()), $options['htmlOptions']);
                            echo '</span>';
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
