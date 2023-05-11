<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\dashboard\components\actions;

use an602\modules\content\widgets\stream\StreamEntryOptions;
use an602\modules\dashboard\stream\DashboardStreamQuery;
use an602\modules\activity\actions\ActivityStreamAction;

/**
 * DashboardStreamAction
 *
 * Note: This stream action is also used for activity e-mail content.
 *
 * @since 0.11
 * @author luke
 */
class DashboardStreamAction extends ActivityStreamAction
{
    /**
     * @inheritDoc
     */
    public $activity = false;

    /**
     * @inheritDoc
     */
    public $streamQueryClass = DashboardStreamQuery::class;

    /**
     * @inheritDoc
     */
    public function initStreamEntryOptions()
    {
        return parent::initStreamEntryOptions()->viewContext(StreamEntryOptions::VIEW_CONTEXT_DASHBOARD);
    }
}
