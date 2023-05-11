<?php

use an602\modules\user\widgets\ProfileHeaderControls;
use an602\modules\friendship\widgets\FriendshipButton;
use an602\modules\user\widgets\ProfileEditButton;
use an602\modules\user\widgets\ProfileHeaderCounterSet;
use an602\modules\user\widgets\UserFollowButton;

/* @var $container \an602\modules\content\components\ContentContainerActiveRecord */
?>
<div class="panel-body">
    <div class="panel-profile-controls">
        <div class="row">
            <div class="col-md-12">
                <?= ProfileHeaderCounterSet::widget(['user' => $container]); ?>

                <div class="controls controls-header pull-right">
                    <?= ProfileHeaderControls::widget([
                        'user' => $container,
                        'widgets' => [
                            [ProfileEditButton::class, ['user' => $container], []],
                            [UserFollowButton::class, ['user' => $container], []],
                            [FriendshipButton::class, ['user' => $container], []],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


