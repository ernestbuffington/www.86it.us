<div class="panel-heading">
    <?= Yii::t('UserModule.account', '<strong>Your</strong> profile'); ?> <?php echo \an602\widgets\DataSaved::widget(); ?>
</div>

<?= an602\modules\user\widgets\AccountProfileMenu::widget(); ?>

<div class="panel-body">
    <?php echo $content; ?>
</div>





