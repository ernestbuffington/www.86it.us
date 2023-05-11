<?php

use an602\libs\Helpers;
use an602\modules\content\components\ContentContainerController;
use yii\helpers\Html;

if (!Yii::$app->controller instanceof ContentContainerController) {
    echo Yii::t('ActivityModule.base', '{displayName} left the space {spaceName}', [
        '{displayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
        '{spaceName}' => '<strong>' . Html::encode(Helpers::truncateText($source->name, 40)) . '</strong>'
    ]);
} else {
    echo Yii::t('ActivityModule.base', '{displayName} left this space.', [
        '{displayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>'
    ]);
}
