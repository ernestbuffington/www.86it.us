<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\components\ActiveRecord;
use an602\modules\content\components\ContentContainerController;
use an602\modules\space\models\Space;
use an602\modules\space\widgets\Image;
use an602\widgets\TimeAgo;
use yii\helpers\Url;

/* @var $originator \an602\modules\user\models\User  */
/* @var $clickable boolean  */
/* @var $record ActiveRecord  */

?>


<?php if ($clickable) : ?>
<a href="<?= Url::to(['/activity/link', 'id' => $record->id])?>">
<?php endif; ?>

    <div class="media">
        <?php if ($originator !== null) : ?>
            <!-- Show user image -->
            <?= $originator->getProfileImage()->render(32, ['class' => 'media-object', 'link' => false, 'htmlOptions' => ['class' => 'pull-left']]) ?>
        <?php endif; ?>

        <!-- Show space image, if you are outside from a space -->
        <?php if (!Yii::$app->controller instanceof ContentContainerController) : ?>
            <?php if ($record->content->container instanceof Space) : ?>
                <?=
                Image::widget([
                    'space' => $record->content->container,
                    'width' => 20,
                    'htmlOptions' => [
                        'class' => 'img-space pull-left',
                    ]
                ])
                ?>
            <?php endif; ?>

        <?php endif; ?>

        <div class="media-body text-break">

            <!-- Show content -->
            <?= $content ?>
            <br>

            <!-- show time -->
            <?= TimeAgo::widget(['timestamp' => $record->content->created_at]) ?>
        </div>
    </div>

<?php if ($clickable) : ?>
</a>
<?php endif; ?>
