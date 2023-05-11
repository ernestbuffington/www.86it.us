<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\libs\Html;
use an602\modules\content\models\Content;
use an602\modules\content\models\forms\ScheduleOptionsForm;
use an602\modules\ui\form\widgets\ActiveForm;
use an602\modules\ui\form\widgets\DatePicker;
use an602\modules\ui\form\widgets\TimePicker;
use an602\widgets\ModalButton;
use an602\widgets\ModalDialog;

/* @var ScheduleOptionsForm $scheduleOptions */
/* @var bool $disableInputs */
?>
<?php ModalDialog::begin(['header' => Yii::t('ContentModule.base', '<strong>Scheduling</strong> Options')]) ?>

    <?php $form = ActiveForm::begin() ?>
    <?= Html::hiddenInput('state', Content::STATE_SCHEDULED) ?>
    <?= Html::hiddenInput('stateTitle', $scheduleOptions->getStateTitle()) ?>
    <?= Html::hiddenInput('scheduledDate', $scheduleOptions->date) ?>

    <div class="modal-body">
        <?= $form->field($scheduleOptions, 'enabled')->checkbox() ?>
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <?= $form->field($scheduleOptions, 'date')
                    ->widget(DatePicker::class, ['options' => ['disabled' => $disableInputs]])
                    ->label(false) ?>
            </div>
            <div class="col-sm-3 col-xs-6" style="padding-left:0">
                <?= $form->field($scheduleOptions, 'time')
                    ->widget(TimePicker::class, ['disabled' => $disableInputs])
                    ->label(false) ?>
            </div>
            <div class="col-xs-12">
                <p class="help-block"><?= Yii::t('ContentModule.base', 'Note: Due to technical reasons there may be a delay of a few minutes.') ?></p>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <?= ModalButton::submitModal() ?>
        <?= ModalButton::cancel() ?>
    </div>

    <?php ActiveForm::end() ?>

<?php ModalDialog::end() ?>

<script <?= Html::nonce() ?>>
$('#scheduleoptionsform-enabled').click(function () {
    $(this).closest('form').find('input[type=text]').prop('disabled', !$(this).is(':checked'));
});
</script>