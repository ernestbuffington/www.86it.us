<?php

use an602\libs\Html;
use an602\modules\ui\view\components\View;

/* @var $this View */
/* @var $rootElement string */
/* @var $options array */
/* @var $bodyLayout $string */
?>

<?= Html::beginTag($rootElement,  $options)?>

    <?= $bodyLayout ?>

<?= Html::endTag($rootElement) ?>

