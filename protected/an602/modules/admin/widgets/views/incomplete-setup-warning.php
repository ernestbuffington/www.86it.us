<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.an602.org/en/licences
 */

use an602\libs\Html;
use an602\modules\admin\widgets\IncompleteSetupWarning;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $problems array */

?>

<div class="panel panel-danger panel-invalid">
    <div class="panel-heading"><?= Yii::t('AdminModule.base', '<strong>Warning</strong> incomplete setup!'); ?></div>
    <div class="panel-body">
        <ul>
            <?php if (in_array(IncompleteSetupWarning::PROBLEM_QUEUE_RUNNER, $problems)): ?>
                <li>
                    <?= Yii::t('AdminModule.base', 'The cron job for the background jobs (queue) does not seem to work properly.'); ?>
                </li>
            <?php endif; ?>
            <?php if (in_array(IncompleteSetupWarning::PROBLEM_CRON_JOBS, $problems)): ?>
                <li>
                    <?= Yii::t('AdminModule.base', 'The cron job for the regular tasks (cron) does not seem to work properly.'); ?>
                </li>
            <?php endif; ?>
        </ul>
        <br />
        <?php if (Yii::$app->user->isAdmin()): ?>
            <?= Html::a(Yii::t('AdminModule.base', 'Open documentation'), 'https://docs.an602.86it.us/docs/admin/cron-jobs', ['class' => 'btn btn-danger', 'target' => '_blank']); ?>
        <?php endif; ?>
    </div>
</div>
