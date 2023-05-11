<?php

use an602\modules\stream\assets\StreamAsset;
use an602\widgets\Button;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \an602\modules\ui\view\components\View */
/* @var $filterNav string */
/* @var $contentContainer \an602\modules\content\components\ContentContainerActiveRecord */

StreamAsset::register($this);

?>

<?php if ($contentContainer && $contentContainer->isArchived()) : ?>
    <span class="label label-warning pull-right" style="margin-top:10px;">
        <?= Yii::t('ContentModule.base', 'Archived'); ?>
    </span>
<?php endif; ?>

<!-- Stream filter section -->
<?= $filterNav ?>

<!-- Stream content -->
<?= Html::beginTag('div', $options) ?>

<!-- DIV for a normal wall stream -->
<div class="s2_stream">
    <div class="back_button_holder" style="display:none">
        <?= Button::primary(Yii::t('ContentModule.base', 'Back to stream'))->action('init')->loader(false)->sm(); ?>
    </div>
    <div class="s2_streamContent" data-stream-content></div>
</div>

<?= Html::endTag('div') ?>

<!-- show "Load More" button on mobile devices -->
<div class="col-md-12 text-center visible-xs visible-sm">
    <?= Button::primary(Yii::t('ContentModule.base', 'Load more'))
        ->id('btn-load-more')
        ->action('loadMore', null, '#wallStream')
        ->lg() ?>
    <br/><br/>
</div>
