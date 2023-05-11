<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\user\models\User;
use an602\widgets\Link;
use an602\widgets\PanelMenu;
use yii\helpers\Html;

/* @var User[] $followers */
/* @var int $totalFollowerCount */
/* @var array $showListOptions */
?>
<div class="panel panel-default follower" id="space-follower-panel">
    <?= PanelMenu::widget([
        'id' => 'space-follower-panel',
        'extraMenus' => Html::tag('li', Link::asLink(Yii::t('SpaceModule.base', 'Show as List'))->icon('list')->options($showListOptions))
    ]) ?>

    <div class="panel-heading"<?= Html::renderTagAttributes($showListOptions + ['style' => 'cursor:pointer']) ?>>
        <?= Yii::t('SpaceModule.base', '<strong>Space</strong> followers') ?> (<?= $totalFollowerCount ?>)
    </div>

    <div class="panel-body">
        <?php foreach ($followers as $follower): ?>
            <?= $follower->getProfileImage()->render(32, [
                'class' => 'img-rounded tt img_margin',
                'showTooltip' => true,
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>