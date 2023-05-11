<?php

use an602\modules\ui\menu\MenuEntry;
use an602\modules\ui\view\components\View;
use an602\modules\user\widgets\PeopleHeadingButtons;
use an602\widgets\Button;
use yii\helpers\Html;

/* @var $this View */
/* @var $menu PeopleHeadingButtons */
/* @var $entries MenuEntry[] */
?>

<?php foreach ($entries as $entry) : ?>
    <?php
    $htmlOptions = $entry->getHtmlOptions();
    if ($entry->getIsActive()) {
        $htmlOptions['active'] = '';
    }
    ?>
    <div style="margin-left: 10px" class="pull-right">
        <?= Button::info($entry->getIcon() . '&nbsp;&nbsp;' . Html::tag('strong', $entry->getLabel()))
            ->link($entry->getUrl())
            ->options($htmlOptions)
            ->sm() ?>
    </div>
<?php endforeach; ?>
