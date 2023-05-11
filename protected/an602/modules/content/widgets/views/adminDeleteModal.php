<?php

use an602\libs\Html;
use an602\modules\content\models\forms\AdminDeleteContentForm;
use an602\modules\ui\form\widgets\ActiveForm;

/* @var $model AdminDeleteContentForm */

?>


<?php $form = ActiveForm::begin(['acknowledge' => true]); ?>

<?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>
<?= $form->field($model, 'notify')->checkbox(['value' => '1', 'checked ' => true]) ?>

<?php ActiveForm::end(); ?>

<script <?= Html::nonce() ?>>
    var $messageTextarea = $('#admindeletecontentform-message');
    var $notifyCheckbox = $('#admindeletecontentform-notify');

    $notifyCheckbox.on('change', function () {
        if($notifyCheckbox.is(':checked'))
            $messageTextarea.removeAttr('disabled');
        else
            $messageTextarea.attr('disabled', 'disabled');
    });
</script>
