<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\queue\interfaces;

/**
 * ExclusiveJobInterface can be added to an ActiveJob to ensure this task is only
 * queued once. As example this is useful for asynchronous jobs like search index rebuild.
 *
 * @see \an602\modules\queue\ActiveJob
 * @author Luke
 */
interface ExclusiveJobInterface
{

    public function getExclusiveJobId();
}
