<?php

use an602\modules\content\widgets\richtext\converter\RichTextToPlainTextConverter;

/* @var $originator \an602\modules\user\models\User */
/* @var $source \an602\modules\content\interfaces\ContentOwner */

echo Yii::t('ContentModule.activities', '{displayName} created a new {contentTitle}.', [
    '{displayName}' => $originator->displayName,
    '{contentTitle}' => $source->getContentName()
]);
?>

"<?= RichTextToPlainTextConverter::process($source->getContentDescription(), [
    RichTextToPlainTextConverter::OPTION_CACHE_KEY => RichTextToPlainTextConverter::buildCacheKeyForContent($source)
]) ?>"
