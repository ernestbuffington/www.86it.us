<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

use an602\modules\topic\widgets\TopicPicker;
use an602\widgets\ModalButton;
use an602\widgets\ModalDialog;
use yii\bootstrap\ActiveForm;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $model \an602\modules\topic\models\forms\ContentTopicsForm */

?>

<?php ModalDialog::begin(['header' => Yii::t('TopicModule.base', '<strong>Manage</strong> Topics')]) ?>
<?php $form = ActiveForm::begin() ?>
<div class="modal-body">
    <?= $form->field($model, 'topics')->widget(TopicPicker::class, ['contentContainer' => $model->getContentContainer()])->label(false) ?>
</div>

<div class="modal-footer">
    <?= ModalButton::submitModal() ?>
    <?= ModalButton::cancel() ?>
</div>

<?php ActiveForm::end() ?>
<?php ModalDialog::end() ?>
