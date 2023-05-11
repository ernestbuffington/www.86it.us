<?php
/* @var $this \an602\modules\ui\view\components\View */

/* @var $container \an602\modules\space\models\Space */

use an602\modules\space\widgets\FollowButton;
use an602\modules\space\widgets\HeaderControls;
use an602\modules\space\widgets\HeaderControlsMenu;
use an602\modules\space\widgets\HeaderCounterSet;
use an602\modules\space\widgets\InviteButton;
use an602\modules\space\widgets\MembershipButton;

?>

<div class="panel-body">
    <div class="panel-profile-controls">
        <div class="row">
            <div class="col-md-12">
                <?= HeaderCounterSet::widget(['space' => $container]); ?>

                <div class="controls controls-header pull-right">
                    <?= HeaderControls::widget(['widgets' => [
                        [InviteButton::class, ['space' => $container], ['sortOrder' => 10]],
                        [MembershipButton::class, [
                            'space' => $container,
                            'options' => ['becomeMember' => ['mode' => 'link']],
                        ], ['sortOrder' => 20]],
                        [FollowButton::class, [
                            'space' => $container,
                            'followOptions' => ['class' => 'btn btn-primary'],
                            'unfollowOptions' => ['class' => 'btn btn-primary active']
                        ], ['sortOrder' => 30]]
                    ]]); ?>
                    <?= HeaderControlsMenu::widget(['space' => $container]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

