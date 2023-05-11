<?php

use yii\helpers\Html;
use an602\modules\content\widgets\richtext\RichText;

/* @var $originator \an602\modules\user\models\User */
/* @var $source \an602\modules\comment\models\Comment */

echo Yii::t('CommentModule.base', "{displayName} wrote a new comment ", [
    '{displayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>'
]);

echo ' "' . RichText::preview($source->message,  100) . '"';
?>