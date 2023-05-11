<?php

use an602\modules\content\widgets\ContainerProfileHeader;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $user \an602\modules\user\models\User */

?>

<?= ContainerProfileHeader::widget(['container' => $user]) ?>
