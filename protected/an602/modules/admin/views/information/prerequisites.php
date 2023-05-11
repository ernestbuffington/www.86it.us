<?php

use yii\helpers\Html;
use yii\helpers\Url;
use an602\modules\admin\widgets\PrerequisitesList;
?>
<p><?= Yii::t('AdminModule.information', 'Checking an602 software prerequisites.'); ?></p>

<?= PrerequisitesList::widget(); ?>
<br>

<?= Html::a(Yii::t('AdminModule.information', 'Re-Run tests'), Url::to(['prerequisites']), ['class' => 'btn btn-primary']); ?>