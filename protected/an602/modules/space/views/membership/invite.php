<?php
use an602\modules\space\models\forms\InviteForm;
use an602\modules\space\models\Space;
use an602\modules\space\widgets\InviteModal;

/**
 * @var $space Space
 * @var $model InviteForm
 */
?>

<?= InviteModal::widget([
    'model' => $model,
    'submitText' => Yii::t('SpaceModule.base', 'Send'),
    'submitAction' => $space->createUrl('/space/membership/invite'),
    'searchUrl' => $space->createUrl('/space/membership/search-invite')
]); ?>
