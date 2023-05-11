<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\queue\driver;

use yii\queue\Queue;

/**
 * Instant queue driver, mainly used for testing purposes
 *
 * @since 1.2
 * @author buddha
 */
class Instant extends Queue
{
    /**
     * @var int the message counter
     */
    protected $messageId = 1;

    /**
     * @inheritdoc
     */
    protected function pushMessage($message, $ttr, $delay, $priority)
    {
        $this->handleMessage($this->messageId, $message, $ttr, 1);
        $this->messageId++;
    }

    /**
     * @inheritdoc
     */
    public function status($id)
    {
        return Queue::STATUS_DONE;
    }
}
