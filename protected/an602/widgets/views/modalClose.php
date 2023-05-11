<?php
 use an602\libs\Html;

 /* @var $success string */
 /* @var $saved boolean */
 /* @var $error string */
 /* @var $warn string */
 /* @var $info string */
 /* @var $script string */
 /* @var $reload boolean*/

?>
<div class="modal-dialog modal-dialog-extra-small animated pulse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-content">
        <?php if (!(empty($success))) : ?>
            <script <?= \an602\libs\Html::nonce() ?>>
                $(function () {an602.modules.ui.status.success('<?= Html::encode($success) ?>')});
            </script>
        <?php elseif ($saved) : ?>
            <script <?= \an602\libs\Html::nonce() ?>>
                $(function () {an602.modules.ui.status.success('<?= Html::encode(Yii::t('base', 'Saved')) ?>')});
            </script>
        <?php elseif (!(empty($error))) : ?>
            <script <?= \an602\libs\Html::nonce() ?>>
                $(function () {an602.modules.ui.status.error('<?= Html::encode($error) ?>')});
            </script>
        <?php elseif (!(empty($warn))) : ?>
            <script <?= \an602\libs\Html::nonce() ?>>
                $(function () {an602.modules.ui.status.warn('<?= Html::encode($warn) ?>')});
            </script>
        <?php elseif (!(empty($info))) : ?>
            <script <?= \an602\libs\Html::nonce() ?>>
                $(function () {an602.modules.ui.status.info('<?= Html::encode($info) ?>')});
            </script>
        <?php endif; ?>
        <script <?= \an602\libs\Html::nonce() ?>>
            $(function () {
                an602.modules.ui.modal.global.close();
                <?php if($script) : ?>
                    <?= $script ?>
                <?php endif; ?>
                <?php if($reload) : ?>
                    an602.modules.client.reload();
                <?php endif; ?>
            });
        </script>
    </div>
</div>
