<?php

use an602\libs\TimezoneHelper;
use an602\modules\content\widgets\ContainerTagPicker;
use an602\modules\ui\form\widgets\ActiveForm;
use an602\modules\user\models\forms\AccountSettings;
use an602\modules\user\widgets\UserPickerField;

/* @var AccountSettings $model */
/* @var array $languages */
?>

<?php $this->beginContent('@user/views/account/_userSettingsLayout.php') ?>

<?php $form = ActiveForm::begin(['id' => 'basic-settings-form', 'acknowledge' => true]); ?>

<?= $form->field($model, 'tags')->widget(ContainerTagPicker::class, ['minInput' => 2]); ?>

<?php if (count($languages) > 1) : ?>
    <?= $form->field($model, 'language')->dropDownList($languages, ['data-ui-select2' => '']); ?>
<?php endif; ?>

<?= $form->field($model, 'timeZone')->dropDownList(TimezoneHelper::generateList(true), ['data-ui-select2' => '']); ?>

<?php if ($model->isVisibilityViewable()): ?>
    <?= $form->field($model, 'visibility')->dropDownList($model->getVisibilityOptions(), [
        'disabled' => !$model->isVisibilityEditable()
    ]); ?>
<?php endif; ?>

<?php if (Yii::$app->getModule('tour')->settings->get('enable') == 1) : ?>
    <?= $form->field($model, 'show_introduction_tour')->checkbox(); ?>
<?php endif; ?>

<?php if (Yii::$app->getModule('user')->allowBlockUsers()) : ?>
    <?= $form->field($model, 'blockedUsers')->widget(UserPickerField::class, ['minInput' => 2]); ?>
<?php endif; ?>

<button class="btn btn-primary" type="submit" data-ui-loader><?= Yii::t('UserModule.account', 'Save') ?></button>

<?php ActiveForm::end(); ?>
<?php $this->endContent(); ?>
