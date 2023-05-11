<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\admin\models\forms\GeneralModuleSettingsForm;
use an602\modules\ui\form\widgets\ActiveForm;
use an602\widgets\ModalButton;
use an602\widgets\ModalDialog;

/* @var GeneralModuleSettingsForm $settings */
?>
<?php ModalDialog::begin(['header' => Yii::t('AdminModule.modules', '<strong>General</strong> Settings')]) ?>

    <?php $form = ActiveForm::begin() ?>

    <div class="modal-body">
        <?= $form->field($settings, 'includeBetaUpdates')->checkbox() ?>
    </div>

    <div class="modal-footer">
        <?= ModalButton::submitModal()?>
        <?= ModalButton::cancel()?>
    </div>

    <?php ActiveForm::end() ?>

<?php ModalDialog::end() ?>
