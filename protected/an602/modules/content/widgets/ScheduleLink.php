<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\libs\Html;
use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\models\Content;
use an602\widgets\Link;
use Yii;
use yii\base\Widget;

/**
 * Schedule link for updating the schedule options of Wall Entries.
 *
 * @package an602.modules_core.wall.widgets
 * @since 1.14
 */
class ScheduleLink extends Widget
{
    public ContentActiveRecord $contentRecord;
    public array $allowedStates = [Content::STATE_DRAFT, Content::STATE_SCHEDULED];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = $this->contentRecord->content;

        if (!in_array($content->state, $this->allowedStates)) {
            return '';
        }

        $contentContainer = $content->container;
        if (!$contentContainer instanceof ContentContainerActiveRecord) {
            return '';
        }

        if (!$content->canEdit()) {
            return '';
        }

        return Html::tag('li', Link::withAction(Yii::t('ContentModule.base', 'Schedule publication'),
                'scheduleOptions',
                $contentContainer->createUrl('/content/content/schedule-options', ['id' => $content->id]))
            ->icon('clock-o'));
    }
}
