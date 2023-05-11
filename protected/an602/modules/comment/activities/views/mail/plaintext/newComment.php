<?php

use an602\modules\content\widgets\richtext\converter\RichTextToPlainTextConverter;

/* @var $originator \an602\modules\user\models\User */
/* @var $source \an602\modules\comment\models\Comment */

echo Yii::t('CommentModule.base', "{displayName} wrote a new comment ", [
    '{displayName}' => $originator->displayName
]);

?>

"<?= RichTextToPlainTextConverter::process($source->message, [
    RichTextToPlainTextConverter::OPTION_CACHE_KEY => RichTextToPlainTextConverter::buildCacheKeyForRecord($source)
]) ?>"
