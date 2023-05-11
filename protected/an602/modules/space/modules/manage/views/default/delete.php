<?php

use an602\modules\ui\form\widgets\ActiveForm;
use an602\modules\space\modules\manage\widgets\DefaultMenu;
use an602\widgets\Button;

/* @var $this \an602\modules\ui\view\components\View
 * @var $model \an602\modules\space\modules\manage\models\DeleteForm
 */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SpaceModule.manage', '<strong>Space</strong> settings'); ?>
    </div>

    <?= DefaultMenu::widget(['space' => $space]); ?>

    <div class="panel-body">
        <p><?= Yii::t('SpaceModule.manage', 'Are you sure, that you want to delete this space? All published content will be removed!'); ?></p>
        <p><?= Yii::t('SpaceModule.manage', 'Please type the name of the space to proceed.'); ?></p>
        <br>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'confirmSpaceName'); ?>

        <hr>
        <?= Button::danger(Yii::t('SpaceModule.manage', 'Delete'))->confirm()->submit() ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
