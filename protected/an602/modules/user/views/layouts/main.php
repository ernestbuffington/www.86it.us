<?php

use an602\assets\AppAsset;
use an602\widgets\FooterMenu;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php $this->head() ?>
    <?= $this->render('@an602/views/layouts/head'); ?>
    <meta charset="<?= Yii::$app->charset ?>">
</head>

<body class="login-container">
<?php $this->beginBody() ?>
<?= $content; ?>
<br />
<?= FooterMenu::widget(['location' => FooterMenu::LOCATION_LOGIN]); ?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
