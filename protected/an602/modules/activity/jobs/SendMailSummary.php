<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\jobs;

use Yii;
use an602\modules\activity\Module;
use an602\modules\queue\interfaces\ExclusiveJobInterface;
use an602\modules\queue\LongRunningActiveJob;
use an602\modules\activity\components\MailSummaryProcessor;
use an602\modules\activity\components\MailSummary;

/**
 * SendMailSummary
 *
 * @since 1.2
 * @author Luke
 */
class SendMailSummary extends LongRunningActiveJob implements ExclusiveJobInterface
{

    /**
     * @var int the interval
     */
    public $interval;

    /**
     * @inhertidoc
     */
    public function getExclusiveJobId()
    {
        return get_class($this) . $this->interval;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('activity');
        if (!$module->enableMailSummaries) {
            return;
        }

        if ($this->interval === MailSummary::INTERVAL_DAILY || $this->interval === MailSummary::INTERVAL_HOURLY || $this->interval === MailSummary::INTERVAL_WEEKLY) {
            MailSummaryProcessor::process($this->interval);
        } else {
            Yii::error('Invalid summary interval given' . $this->interval, 'activity.job');
            return;
        }
    }

    /**
     * @inheritDoc
     */
    public function canRetry($attempt, $error)
    {
        return false;
    }

}
