<?php

use an602\modules\user\models\User;
use an602\libs\Helpers;

/* @var $originator User */
/* @var $source \an602\modules\space\models\Space */

echo Yii::t('ActivityModule.base', "{displayName} joined the space {spaceName}", [
    '{displayName}' => $originator->displayName,
    '{spaceName}' => '"' . Helpers::truncateText($source->name, 40) . '"'
]);
?>
