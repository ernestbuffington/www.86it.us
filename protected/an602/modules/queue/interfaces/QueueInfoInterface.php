<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\queue\interfaces;

/**
 * QueueInfoInterface
 *
 * @author Luke
 */
interface QueueInfoInterface
{
    /**
     * @return int|null the number of waiting jobs in the queue
     */
    public function getWaitingJobCount();

    /**
     * @return int|null the number of delayed jobs in the queue
     */
    public function getDelayedJobCount();

    /**
     * @return int|null the number of reserved jobs in the queue
     */
    public function getReservedJobCount();

    /**
     * @return int|null the number of done jobs in the queue
     */
    public function getDoneJobCount();
}
