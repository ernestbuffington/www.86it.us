<?php

use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\widgets\stream\WallStreamEntryOptions;
use an602\modules\content\widgets\WallEntryAddons;
use an602\modules\ui\view\components\View;

/* @var $this View */
/* @var $model ContentActiveRecord */
/* @var $renderOptions WallStreamEntryOptions */

?>

<?php if (!$renderOptions->isAddonsDisabled()) : ?>
    <div class="stream-entry-addons clearfix">
        <?= WallEntryAddons::widget(['object' => $model, 'renderOptions' => $renderOptions]) ?>
    </div>
<?php endif; ?>
