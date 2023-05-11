<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

use yii\helpers\Html;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $options array */
/* @var $title string */
/* @var $value boolean */
/* @var $checked boolean */
/* @var $iconInActive boolean */
/* @var $iconActive boolean */
?>

<?= Html::beginTag('a', $options) ?>
<i class="fa  <?= ($checked) ? $iconActive : $iconInActive ?>"></i> <?= $title ?>
<?= Html::endTag('a') ?>

