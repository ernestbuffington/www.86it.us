<?php

use an602\modules\admin\models\forms\CacheSettingsForm;
use an602\widgets\Button;
use an602\modules\ui\form\widgets\ActiveForm;

/* @var $cacheTypes [] */
/* @var $model CacheSettingsForm */

?>

<?php $this->beginContent('@admin/views/setting/_advancedLayout.php') ?>

    <?php $form = ActiveForm::begin(['acknowledge' => true]); ?>

        <?= $form->field($model, 'type')->dropDownList($cacheTypes, ['readonly' => Yii::$app->settings->isFixed('cache.class')]) ?>


        <?= $form->field($model, 'expireTime')->textInput(['readonly' => Yii::$app->settings->isFixed('cache.expireTime')]) ?>

        <hr>
        <?= Button::primary(Yii::t('AdminModule.settings', 'Save & Flush Caches'))->submit() ?>

    <?php ActiveForm::end(); ?>

<?php $this->endContent(); ?>
