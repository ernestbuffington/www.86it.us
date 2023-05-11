<?php

use an602\modules\user\widgets\PermissionGridEditor;
?>
<?php $this->beginContent('@admin/views/group/_manageLayout.php', ['group' => $group]) ?>
<div class="panel-body">
    <?= PermissionGridEditor::widget(['permissionManager' => Yii::$app->user->permissionManager, 'groupId' => $group->id, 'hideFixedPermissions' => false]); ?>
</div>
<?php $this->endContent(); ?>