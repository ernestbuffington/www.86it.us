<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\components\Module;
use an602\modules\admin\widgets\ModuleCard;

/* @var string $type */
/* @var string|bool $title */
/* @var int $count */
/* @var string $noModulesMessage */
/* @var string $view */
/* @var string $moduleTemplate */
/* @var Module[] $modules */
?>
<?php if ($title !== false) : ?>
    <h4 class="modules-type"><?= $title ?> (<span class="group-modules-count-<?= $type ?>"><?= $count ?></span>)</h4>
<?php endif; ?>

<div class="row cards">
    <?php if (empty($modules)) : ?>
        <div class="col-md-12 cards-no-results">
            <?php if ($count) : ?>
                <strong><?= Yii::t('AdminModule.modules', 'No modules found.') ?></strong><br/>
                <?= Yii::t('AdminModule.modules', 'Try other keywords or remove filters.') ?>
            <?php elseif (isset($noModulesMessage)) : ?>
                <strong><?= $noModulesMessage ?></strong>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php foreach ($modules as $module) : ?>
        <?= ModuleCard::widget([
            'module' => $module,
            'view' => $view ?? null,
            'template' => $moduleTemplate ?? null,
        ]); ?>
    <?php endforeach; ?>
</div>
