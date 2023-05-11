<?php

use an602\assets\TopNavigationAsset;
use an602\libs\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $menu \an602\widgets\TopMenu */
/* @var $entries \an602\modules\ui\menu\MenuEntry[] */

TopNavigationAsset::register($this);

?>

<?php foreach ($entries as $entry) : ?>
    <li class="top-menu-item <?php if ($entry->getIsActive()): ?>active<?php endif; ?>">
        <?= Html::a($entry->getIcon() . '<br />' . $entry->getLabel(), $entry->getUrl(), $entry->getHtmlOptions()); ?>
    </li>
<?php endforeach; ?>

<li id="top-menu-sub" class="dropdown" style="display:none;">
    <a href="#" id="top-dropdown-menu" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-align-justify"></i><br>
        <?= Yii::t('base', 'Menu'); ?>
        <b class="caret"></b>
    </a>
    <ul id="top-menu-sub-dropdown" class="dropdown-menu dropdown-menu-right">

    </ul>
</li>
