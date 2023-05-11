<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use yii\bootstrap\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $options [] */
/* @var $selection [] */
/* @var $items [] */
?>
<div class="form-group">
    <?= Html::dropDownList(null, $selection, $items, $options) ?>
</div>
