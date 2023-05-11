<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\assets\CardsAsset;
use an602\libs\Html;
use an602\modules\space\components\SpaceDirectoryQuery;
use an602\modules\space\widgets\SpaceDirectoryCard;
use an602\modules\space\widgets\SpaceDirectoryFilters;
use yii\web\View;

/* @var $this View */
/* @var $spaces SpaceDirectoryQuery */

CardsAsset::register($this);
?>
<div class="panel panel-default">

    <div class="panel-heading">
        <?= Yii::t('SpaceModule.base', '<strong>Spaces</strong>'); ?>
    </div>

    <div class="panel-body">
        <?= SpaceDirectoryFilters::widget(); ?>
    </div>

</div>

<div class="row cards">
    <?php if (!$spaces->exists()): ?>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <strong><?= Yii::t('SpaceModule.base', 'No results found!'); ?></strong><br/>
                <?= Yii::t('SpaceModule.base', 'Try other keywords or remove filters.'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($spaces->all() as $space) : ?>
        <?= SpaceDirectoryCard::widget(['space' => $space]); ?>
    <?php endforeach; ?>
</div>

<?php if (!$spaces->isLastPage()) : ?>
    <?= Html::tag('div', '', [
        'class' => 'cards-end',
        'data-current-page' => $spaces->pagination->getPage() + 1,
        'data-total-pages' => $spaces->pagination->getPageCount(),
    ]) ?>
<?php endif; ?>
