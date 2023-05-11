<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\jobs;

use Yii;
use an602\modules\queue\LongRunningActiveJob;
use an602\modules\queue\interfaces\ExclusiveJobInterface;

/**
 * RebuildIndex job
 *
 * @since 1.3
 * @author Luke
 */
class RebuildIndex extends LongRunningActiveJob implements ExclusiveJobInterface
{
    /**
     * @inhertidoc
     */
    public function getExclusiveJobId()
    {
        return 'search.rebuild-index';
    }

    /**
     * @inhertidoc
     */
    public function run()
    {
        Yii::$app->search->rebuild();
    }

    /**
     * @inheritDoc
     */
    public function canRetry($attempt, $error)
    {
        return false;
    }
}
