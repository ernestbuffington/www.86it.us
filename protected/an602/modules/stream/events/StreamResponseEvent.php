<?php

namespace an602\modules\stream\events;

use an602\modules\stream\actions\Stream;
use an602\modules\stream\actions\StreamResponse;
use yii\base\Event;

class StreamResponseEvent extends Event
{

    /**
     * @var Stream
     */
    public $sender;

    /**
     * @var StreamResponse
     */
    public $response;
}
