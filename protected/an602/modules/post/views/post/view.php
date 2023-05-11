<?php

use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\widgets\stream\StreamEntryOptions;
use an602\modules\content\widgets\stream\StreamEntryWidget;
use an602\modules\post\models\Post;
use an602\modules\stream\assets\StreamAsset;
use an602\modules\ui\view\components\View;

/* @var $this View */
/* @var $post Post */
/* @var $contentContainer ContentContainerActiveRecord */
/* @var $renderOptions StreamEntryOptions */

StreamAsset::register($this);
?>

<div data-action-component="stream.SimpleStream">
    <?= StreamEntryWidget::renderStreamEntry($post, $renderOptions) ?>
</div>


