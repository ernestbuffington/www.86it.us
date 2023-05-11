<?php

use an602\modules\marketplace\widgets\AboutVersion;
use yii\helpers\Html;
?>


<?= AboutVersion::widget(); ?>
<br />

<?php if ($isNewVersionAvailable) : ?>
    <div class="alert alert-danger">
        <p>
            <strong><?= Yii::t('AdminModule.information', 'There is a new update available! (Latest version: %version%)', ['%version%' => $latestVersion]); ?></strong><br>
            <?= Html::a("https://www.an602.org", "https://www.an602.org"); ?>
        </p>
    </div>
<?php elseif ($isUpToDate): ?>
    <div class="alert alert-info">
        <p>
            <strong><?= Yii::t('AdminModule.information', 'This an602 installation is up to date!'); ?></strong><br />
            <?= Html::a("https://www.an602.org", "https://www.an602.org"); ?>
        </p>
    </div>
<?php endif; ?>

<br>

<?php if (YII_DEBUG) : ?>
    <p class="alert alert-danger">
        <strong><?= Yii::t('AdminModule.information', 'an602 is currently in debug mode. Disable it when running on production!'); ?></strong><br>
        <?= Yii::t('AdminModule.information', 'See installation manual for more details.'); ?>
    </p>
<?php endif; ?>

<hr>
© <?= date("Y") ?> H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
&middot;
<?= Html::a(Yii::t('AdminModule.information', 'Licences'), "https://www.an602.org/licences", ['target' => '_blank']); ?>
