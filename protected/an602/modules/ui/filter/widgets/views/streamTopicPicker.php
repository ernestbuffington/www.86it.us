<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/* @var $this \an602\modules\ui\view\components\View */

use an602\modules\topic\widgets\TopicPicker;

?>

<?= TopicPicker::widget([
    'id' => 'stream-topic-picker',
    'name' => 'stream-topic-picker',
    'addOptions' => false
])
?>
