<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic\widgets;

use an602\modules\content\models\ContentTag;
use an602\modules\topic\models\Topic;
use an602\widgets\Label;
use an602\widgets\Link;
use yii\helpers\Html;

class TopicLabel extends Label
{
    /**
     * @param Topic $topic
     * @return $this
     */
    public static function forTopic(Topic $topic)
    {
        $link = Link::withAction('', 'topic.addTopic')->options(['data-topic-id' => $topic->id, 'data-topic-url' => $topic->getUrl()]);

        return static::light($topic->name)->sortOrder(20)->color($topic->color)->withLink($link)->icon('fa-star');
    }

}
