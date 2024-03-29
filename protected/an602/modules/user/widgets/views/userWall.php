<?php

use an602\libs\Html;
use an602\modules\user\models\User;use an602\modules\user\widgets\Image;
use an602\modules\user\widgets\PeopleTagList;

/* @var User $user */
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="media">
            <span class="label label-default pull-right"><?php echo Yii::t('UserModule.base', 'User'); ?></span>
            <?= Image::widget(['user' => $user, 'width' => 40, 'htmlOptions' => ['class' => 'pull-left']]); ?>
            <div class="media-body">
                <h4 class="media-heading"><?= Html::containerLink($user); ?></h4>
                <h5><?= Html::encode($user->displayNameSub); ?></h5>
                <?= PeopleTagList::widget(['user' => $user]); ?>
            </div>
        </div>
    </div>
</div>