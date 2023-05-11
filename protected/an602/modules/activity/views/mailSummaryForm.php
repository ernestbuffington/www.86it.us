<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

/* @var $model an602\modules\activity\models\MailSummaryForm */
/* @var $form an602\widgets\ActiveForm */

use an602\libs\Html;
use an602\modules\ui\form\widgets\ActiveForm;
use an602\modules\space\widgets\SpacePickerField;
?>

<?php $form = ActiveForm::begin(['enableClientValidation' => false, 'acknowledge' => true]); ?>

    <?= $form->field($model, 'interval')->dropDownList($model->getIntervals()) ?>
    <?= $form->field($model, 'limitSpacesMode')->radioList($model->getLimitSpaceModes()) ?>
    <?= $form->field($model, 'limitSpaces')->widget(SpacePickerField::class, [])->label(false) ?>
    <?= $form->field($model, 'activities')->checkboxList($model->getActivitiesArray(), [
        'labelOptions' => [
            'encode' => false
        ], 'encode' => true]) ?>

    <br>
    <?= Html::saveButton() ?>
    <?php if ($model->canResetAllUsers()): ?>
        <?= Html::a(Yii::t('NotificationModule.base', 'Reset for all users'), ['reset-all-users'], [
            'data-confirm' => Yii::t('NotificationModule.base', 'Do you want to reset the settings concerning email summaries for all users?'),
            'class' => 'btn btn-danger pull-right',
            'data-method' => 'POST',
        ]) ?>
    <?php endif; ?>
    <?php if ($model->userSettingsLoaded): ?>
        <?= Html::a(Yii::t('NotificationModule.base', 'Reset to defaults'), ['reset'], ['class' => 'btn btn-default pull-right', 'data-ui-loader' => '', 'data-method' => 'POST']) ?>
    <?php endif; ?>

<?php ActiveForm::end(); ?>
