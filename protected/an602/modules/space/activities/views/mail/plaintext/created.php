<?php

use an602\libs\Helpers;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;

/* @var $originator User */
/* @var $source Space */

echo Yii::t('ActivityModule.base', "{displayName} created the new space {spaceName}", [
    '{displayName}' => $originator->displayName,
    '{spaceName}' => '"' . Helpers::truncateText($source->name, 25) . '"'
]);
?>
