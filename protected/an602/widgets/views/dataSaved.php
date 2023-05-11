<!-- check if flash message exists -->
<?php if(Yii::$app->getSession()->hasFlash('data-saved')): ?>

    <script <?= \an602\libs\Html::nonce() ?>>
        $(function() {
            an602.modules.log.success('<?php echo Yii::$app->getSession()->getFlash('data-saved'); ?>', true);
        });
    </script>

<?php endif; ?>





