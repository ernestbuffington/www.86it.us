<?php
use an602\widgets\ModalButton;
?>

<?= ModalButton::primary(Yii::t('SpaceModule.base', 'Invite'))
    ->load($space->createUrl('/space/membership/invite'))->icon('invite') ?>
