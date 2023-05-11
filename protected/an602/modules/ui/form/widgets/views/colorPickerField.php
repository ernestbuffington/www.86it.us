<?php

use yii\helpers\Html;

an602\assets\an602ColorPickerAsset::register($this);

/* @var $model \yii\base\Model*/
/* @var $field string */
/* @var $inputId string */
/* @var $container string */

?>

<?= Html::activeTextInput($model, $field, ['class' => 'form-control', 'id' => $inputId, 'value' => $model->$field, 'style' => 'display:none']); ?>

<script <?= \an602\libs\Html::nonce() ?>>
    $(function() {
        an602.modules.ui.colorpicker.apply('#<?= $container ?>', '#<?= $inputId ?>', '<?= $model->$field ?>')
    });
</script>
