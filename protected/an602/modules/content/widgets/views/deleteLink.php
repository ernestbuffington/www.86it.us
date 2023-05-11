<?php

use an602\modules\ui\icon\widgets\Icon;
use yii\helpers\Url;

/* @var $this an602\modules\ui\view\components\View */
/* @var $isAdmin boolean */
?>
<li>
    <!-- load modal confirm widget -->
    <a  href="#" data-action-click="<?= $isAdmin ? 'adminDelete' : 'delete' ?>" data-content-delete-url="<?= $isAdmin ? Url::to(['/content/content/admin-delete']) : Url::to(['/content/content/delete']) ?>">
        <?= Icon::get('delete') ?> <?= Yii::t('ContentModule.base', 'Delete') ?>
    </a>
</li>
