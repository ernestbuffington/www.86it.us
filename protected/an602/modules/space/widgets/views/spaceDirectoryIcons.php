<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\space\models\Space;
use an602\widgets\Link;
use yii\helpers\Html;

/* @var $space Space */
/* @var $membersCount int */
/* @var $canViewMembers bool */

$text = ' <span>' . $membersCount . '</span>';
$class = 'fa fa-users';
?>
<?php if ($canViewMembers) : ?>
    <?= Link::withAction($text, 'ui.modal.load', $space->createUrl('/space/membership/members-list'))->cssClass($class) ?>
<?php else: ?>
    <?= Html::tag('span', $text, ['class' => $class]) ?>
<?php endif; ?>