<?php

use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\widgets\WallEntryLabels;
use an602\modules\topic\models\Topic;
use an602\modules\topic\widgets\TopicLabel;
use an602\modules\ui\view\components\View;

/* @var $this View */
/* @var $model ContentActiveRecord */
/* @var $header string */
/* @var $content string */
/* @var $footer string */

?>

<div class="panel panel-default wall_<?= $model->getUniqueId() ?>">
    <div class="panel-body">
        <div class="media wall-entry-header">
            <?= $header ?>
        </div>

        <div class="wall-entry-body">
            <div class="topic-label-list">
                <?php foreach (Topic::findByContent($model->content)->all() as $topic) : ?>
                    <?= TopicLabel::forTopic($topic) ?>
                <?php endforeach; ?>
            </div>

            <div class="wall-entry-content content" id="wall_content_<?= $model->getUniqueId() ?>">
                <?= $content ?>
            </div>

            <div class="wall-entry-footer">
                <?= $footer ?>
            </div>
        </div>
    </div>
</div>
