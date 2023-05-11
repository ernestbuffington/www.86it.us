<?php
use an602\libs\Html;

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */
?>

<script <?= Html::nonce() ?>>
    $(document).one('an602:ready', function() {
        if(an602 && an602.modules.notification && an602.modules.notification.menu) {
            an602.modules.notification.menu.updateCount(<?= $count ?>);
        }
    });
</script>