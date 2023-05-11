<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\activity\actions;

use an602\modules\activity\stream\ActivityStreamQuery;
use an602\modules\content\widgets\stream\StreamEntryOptions;
use an602\modules\content\widgets\stream\WallStreamEntryOptions;
use an602\modules\stream\actions\ContentContainerStream;

/**
 * This action can be used as container related wall- and activity stream. This stream action can be used as wall stream
 * action by setting the $activity flag to true. By default this stream action will serve activity stream channel content
 * only until the $activity flag is set to false.
 *
 * This action type is useful for streams types supporting both, a wall as well as activity stream.
 *
 * @package an602\modules\activity\actions
 */
class ActivityStreamAction extends ContentContainerStream
{
    /**
     * @var bool if true the stream will search for activity content
     */
    public $activity = true;

    /**
     * @inheritDoc
     */
    public $streamQueryClass = ActivityStreamQuery::class;

    /**
     * @inheritDoc
     */
    public function initQuery($options = [])
    {
        $options['activity'] = $this->activity;
        return parent::initQuery($options);
    }

    /**
     * @return StreamEntryOptions
     */
    public function initStreamEntryOptions()
    {
        return $this->activity
            ? new StreamEntryOptions()
            : new WallStreamEntryOptions();
    }
}
