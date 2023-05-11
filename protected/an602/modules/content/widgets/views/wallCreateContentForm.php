<?php

use an602\modules\content\widgets\WallCreateContentForm;
use an602\modules\content\widgets\WallCreateContentMenu;
use an602\modules\ui\form\widgets\ActiveForm;
use an602\modules\content\assets\ContentFormAsset;
use an602\modules\space\models\Space;

/* @var $wallCreateContentForm WallCreateContentForm */
/* @var $defaultVisibility integer */
/* @var $contentContainer \an602\modules\content\components\ContentContainerActiveRecord */

ContentFormAsset::register($this);

$this->registerJsConfig('content.form', [
    'defaultVisibility' => $defaultVisibility,
    'disabled' => ($contentContainer instanceof Space && $contentContainer->isArchived()),
    'text' => [
        'makePrivate' => Yii::t('ContentModule.base', 'Change to "Private"'),
        'makePublic' => Yii::t('ContentModule.base', 'Change to "Public"'),
        'info.archived' => Yii::t('ContentModule.base', 'This space is archived.')
    ]
]);
?>

<?php if (WallCreateContentMenu::canCreateEntry($contentContainer, 'form')) : ?>
<div class="panel panel-default clearfix">
    <div class="panel-body" id="contentFormBody" style="display:none;" data-action-component="content.form.CreateForm" >
        <?php $form = ActiveForm::begin(['acknowledge' => true]); ?>

        <?= $wallCreateContentForm->renderActiveForm($form) ?>

        <?php ActiveForm::end(); ?>
    </div><!-- /panel body -->
</div><!-- /panel -->
<?php endif; ?>