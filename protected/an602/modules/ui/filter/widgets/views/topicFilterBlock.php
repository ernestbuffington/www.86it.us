<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

use an602\libs\Html;
use an602\modules\topic\widgets\TopicPicker;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $title string */

?>

<?= Html::beginTag('div', $options) ?>
    <strong><?= $title ?></strong>
    <?= TopicPicker::widget([
        'id' => 'stream_filter_topic',
        'name' => 'filter_topic'
    ]); ?>
<?= Html::endTag('div') ?>
