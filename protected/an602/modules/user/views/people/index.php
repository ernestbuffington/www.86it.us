<?php

use an602\assets\CardsAsset;
use an602\libs\Html;
use an602\modules\user\components\PeopleQuery;
use an602\modules\user\widgets\PeopleCard;
use an602\modules\user\widgets\PeopleFilters;
use an602\modules\user\widgets\PeopleHeadingButtons;

/* @var $this \yii\web\View */
/* @var $people PeopleQuery */

CardsAsset::register($this);
?>
<div class="panel panel-default">

    <div class="panel-heading">
        <?php if ($people->isFilteredByGroup()) : ?>
            <?= Yii::t('UserModule.base', '<strong>Group</strong> members - {group}', ['{group}' => Html::encode($people->filteredGroup->name)]); ?>
            <?php if (!empty($people->filteredGroup->description)) : ?>
                <div class="hint-block"><?= Html::encode($people->filteredGroup->description) ?></div>
            <?php endif; ?>
        <?php else: ?>
            <?= Yii::t('UserModule.base', '<strong>People</strong>'); ?>
        <?php endif; ?>

        <?= PeopleHeadingButtons::widget() ?>
    </div>

    <div class="panel-body">
        <?= PeopleFilters::widget(); ?>
    </div>

</div>

<div class="row cards">
    <?php if (!$people->exists()): ?>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <strong><?= Yii::t('UserModule.base', 'No results found!'); ?></strong><br/>
                    <?= Yii::t('UserModule.base', 'Try other keywords or remove filters.'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($people->all() as $user) : ?>
        <?= PeopleCard::widget(['user' => $user]); ?>
    <?php endforeach; ?>
</div>

<?php if (!$people->isLastPage()) : ?>
    <?= Html::tag('div', '', [
        'class' => 'cards-end',
        'data-current-page' => $people->pagination->getPage() + 1,
        'data-total-pages' => $people->pagination->getPageCount(),
        'data-ui-loader' => '',
    ]) ?>
<?php endif; ?>
