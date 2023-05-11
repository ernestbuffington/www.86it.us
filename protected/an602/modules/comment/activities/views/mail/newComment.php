<?php

use an602\modules\content\widgets\richtext\converter\RichTextToShortTextConverter;
use an602\modules\content\widgets\richtext\RichText;
use yii\helpers\Html;

/* @var $originator \an602\modules\user\models\User */
/* @var $source \an602\modules\comment\models\Comment */

echo Yii::t('CommentModule.base', "{displayName} wrote a new comment ", [
    '{displayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>'
]);
?>
<br>

"<?= RichText::preview($source->message, 0, [
    RichTextToShortTextConverter::OPTION_CACHE_KEY => RichTextToShortTextConverter::buildCacheKeyForRecord($source)
]) ?>"
