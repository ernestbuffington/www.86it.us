<?php
use an602\widgets\ModalDialog;
use yii\bootstrap\ActiveForm;
use an602\modules\space\widgets\SpacePickerField;
use an602\widgets\ModalButton;
use an602\widgets\Button;

/* @var $model \an602\modules\content\models\forms\MoveContentForm */

$movableResult = $model->isMovable();
$canMove = $model->isMovable() === true;

?>

<?php ModalDialog::begin(['header' => Yii::t('ContentModule.base', '<strong>Move</strong> content')]) ?>
 <?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
    <div class="modal-body">
        <?php if($canMove): ?>
              <?= $form->field($model, 'target')->widget(SpacePickerField::class, [
                      'maxSelection' => 1,
                      'focus' => true,
                      'url' => $model->getSearchUrl()
              ])?>
        <?php else: ?>
            <div class="alert alert-warning">
                <?= Yii::t('ContentModule.base', $movableResult); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
        <?= Button::primary(Yii::t('base', 'Save'))->action('content.submitMove')->submit()->loader(true)->visible($canMove) ?>
        <?= ModalButton::cancel() ?>
    </div>
 <?php ActiveForm::end() ?>
<?php ModalDialog::end() ?>
