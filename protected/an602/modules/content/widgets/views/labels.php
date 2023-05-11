<?php

use an602\modules\post\models\Post;
use an602\widgets\Label;

/**
 * This view shows common labels for wall entries.
 * Its used by WallEntryLabelWidget.
 *
 * @var \an602\modules\content\components\ContentActiveRecord $object the content object (e.g. Post)
 *
 * @since 0.5
 */
?>
<span class="wallentry-labels">
    <?php foreach ($object->getLabels() as $label) : ?>
        <?= $label ?>
    <?php endforeach; ?>
<span>