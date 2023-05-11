<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use DateTime;
use DateTimeZone;
use an602\components\Widget;
use an602\libs\Html;
use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\models\Content;
use Yii;

/**
 * Can be used to render an archive icon for archived content.
 * @package an602\modules\content\widgets
 * @since 1.14
 */
class StateBadge extends Widget
{
    public ?ContentActiveRecord $model;

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function run()
    {
        if ($this->model === null) {
            return '';
        }

        switch ($this->model->content->state) {
            case Content::STATE_DRAFT:
                return Html::tag('span', Yii::t('ContentModule.base', 'Draft'),
                    ['class' => 'label label-danger label-state-draft']
                );
            case Content::STATE_SCHEDULED:
                $scheduledDateTime = new DateTime($this->model->content->scheduled_at, new DateTimeZone('UTC'));
                return Html::tag('span', Yii::t('ContentModule.base', 'Scheduled at {dateTime}', [
                        'dateTime' => Yii::$app->formatter->asDatetime($scheduledDateTime, 'short')
                    ]),
                    ['class' => 'label label-warning label-state-scheduled']
                );
            case Content::STATE_DELETED:
                return Html::tag('span', Yii::t('ContentModule.base', 'Deleted'),
                    ['class' => 'label label-danger label-state-deleted']
                );
        }

        return '';
    }
}
