<?php

use an602\modules\ui\form\widgets\ActiveForm;
use an602\modules\ui\form\widgets\SortOrderField;
use an602\modules\user\models\ProfileFieldCategory;
use an602\widgets\Button;
use yii\helpers\Url;
use an602\libs\Html;

/* @var $category ProfileFieldCategory */
?>
<div class="panel-body">
    <div class="pull-right">
        <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview'), 'class' => 'pull-right']); ?>
    </div>

    <?php if (!$category->isNewRecord): ?>
        <h4><?= Yii::t('AdminModule.user', 'Edit profile category'); ?></h4>
    <?php else: ?>
        <h4><?= Yii::t('AdminModule.user', 'Create new profile category'); ?></h4>
    <?php endif; ?>
    <br>

    <?php $form = ActiveForm::begin(['acknowledge' => true]); ?>

    <?= $form->field($category, 'title') ?>
    <?= $form->field($category, 'description')->textarea(['rows' => 5]) ?>
    <?= $form->field($category, 'sort_order')->widget(SortOrderField::class) ?>
    <?= $form->field($category, 'translation_category') ?>

    <hr>

    <?= Button::save()->submit() ?>

    <?php if (!$category->isNewRecord && !$category->is_system): ?>
        <?= Button::danger(Yii::t('AdminModule.user', 'Delete'))
            ->link(Url::to(['delete-category', 'id' => $category->id]))->confirm()->right() ?>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>
