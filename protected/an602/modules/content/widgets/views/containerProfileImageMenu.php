<?php

use an602\modules\file\widgets\Upload;
use an602\widgets\Button;
use an602\widgets\ModalButton;
use an602\widgets\ModalConfirm;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $upload Upload */
/* @var $cropUrl string */
/* @var $deleteUrl string */
/* @var $hasImage string */
/* @var $confirmBody string */
/* @var $dropZone string */

$editButtonStyle = $hasImage ? '' : 'display: none;';

if (!isset($dropZone)) {
    $dropZone = null;
}

if (!isset($confirmBody)) {
    $confirmBody = null;
}
?>

<div class="image-upload-buttons">

    <?= $upload->button([
        'cssButtonClass' => 'btn btn-info btn-sm profile-image-upload',
        'tooltip' => false,
        'dropZone' => $dropZone,
        'options' => ['class' => 'profile-upload-input']]) ?>

    <?= ModalButton::info()->style($editButtonStyle)->sm()
        ->load($cropUrl)->icon('edit')
        ->cssClass('profile-image-edit profile-image-crop') ?>

    <?= Button::danger()
        ->icon('remove')
        ->action('delete', $deleteUrl)
        ->style($editButtonStyle)->sm()
        ->loader(false)
        ->cssClass('profile-image-edit profile-image-delete')
        ->confirm(
            Yii::t('SpaceModule.base', '<strong>Confirm</strong> image deletion'),
            $confirmBody,
            Yii::t('SpaceModule.base', 'Delete'),
            Yii::t('SpaceModule.base', 'Cancel')) ?>
</div>
