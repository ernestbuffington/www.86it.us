<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic\widgets;

use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\models\Content;
use an602\widgets\ModalButton;
use an602\modules\topic\models\Topic;
use an602\modules\content\widgets\WallEntryControlLink;
use an602\widgets\Link;
use Yii;
use yii\helpers\Url;

class ContentTopicButton extends WallEntryControlLink
{
    /**
     * @var ContentActiveRecord
     */
    public $record;

    public function renderLink()
    {
        if ($this->record->content->state === Content::STATE_DELETED) {
            return '';
        }

        return ModalButton::asLink(Yii::t('TopicModule.base', 'Topics'))->icon(Topic::getIcon())
            ->load(Url::to(['/topic/content-topic', 'contentId' => $this->record->content->id]));
    }
}
