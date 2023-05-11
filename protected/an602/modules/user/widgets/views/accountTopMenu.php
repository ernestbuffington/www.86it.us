<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\ui\menu\DropdownDivider;
use an602\widgets\FooterMenu;
use \yii\helpers\Html;
use \yii\helpers\Url;
use an602\modules\user\widgets\Image;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $menu \an602\modules\ui\menu\widgets\DropdownMenu */
/* @var $entries \an602\modules\ui\menu\MenuEntry[] */
/* @var $options [] */

/** @var \an602\modules\user\models\User $userModel */

$userModel = Yii::$app->user->identity;

?>

<?php if (Yii::$app->user->isGuest): ?>
    <?php if(!empty($entries)) :?>
        <?= $entries[0]->render() ?>
    <?php endif; ?>
<?php else: ?>
    <?= Html::beginTag('ul', $options) ?>
        <li class="dropdown account">
            <a href="#" id="account-dropdown-link" class="dropdown-toggle" data-toggle="dropdown" aria-label="<?= Yii::t('base', 'Profile dropdown') ?>">

                <?php if ($this->context->showUserName): ?>
                    <div class="user-title pull-left hidden-xs">
                        <strong><?= Html::encode($userModel->displayName); ?></strong><br/><span class="truncate"><?= Html::encode($userModel->displayNameSub); ?></span>
                    </div>
                <?php endif; ?>

                <?= Image::widget([
                        'user' => $userModel,
                        'link'  => false,
                        'width' => 32,
                        'htmlOptions' => [
                                'id' => 'user-account-image',
                 ]])?>

                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu pull-right">
                <?php foreach ($entries as $entry): ?>
                    <?php if(!($entry instanceof DropdownDivider)) : ?><li><?php endif; ?>
                        <?= $entry->render() ?>
                    <?php if(!($entry instanceof DropdownDivider)) : ?></li><?php endif; ?>
                <?php endforeach; ?>
                <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_ACCOUNT_MENU]); ?>
            </ul>
        </li>
    <?= Html::endTag('ul') ?>
<?php endif; ?>
