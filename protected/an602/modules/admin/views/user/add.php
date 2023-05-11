<?php

use an602\compat\HForm;
use an602\widgets\Button;
use an602\widgets\ModalButton;
use an602\modules\ui\form\widgets\ActiveForm;

/* @var $hForm HForm */
?>

<div class="panel-body">
    <div class="clearfix">

        <div class="pull-right">
            <?= Button::back(['index'], Yii::t('AdminModule.base', 'Back to overview'))
                ->right(false) ?>

            <?= ModalButton::success(Yii::t('AdminModule.user', 'Invite new people'))
                ->load(['/user/invite', 'adminIsAlwaysAllowed' => true])->icon('invite')->sm() ?>
        </div>

        <h4 class="pull-left"><?= Yii::t('AdminModule.user', 'Add new user') ?></h4>
    </div>
    <br>
    <?php $form = ActiveForm::begin(['options' => ['data-ui-widget' => 'ui.form.TabbedForm', 'data-ui-init' => ''], 'acknowledge' => true]); ?>
        <?= $hForm->render($form); ?>
    <?php ActiveForm::end(); ?>
</div>
