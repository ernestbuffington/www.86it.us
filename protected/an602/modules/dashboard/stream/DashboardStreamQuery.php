<?php

namespace an602\modules\dashboard\stream;

use an602\modules\activity\stream\ActivityStreamQuery;
use an602\modules\dashboard\Module;
use an602\modules\dashboard\stream\filters\DashboardGuestStreamFilter;
use an602\modules\dashboard\stream\filters\DashboardMemberStreamFilter;
use Yii;

/**
 * Class DashboardStreamQuery
 *
 * @since 1.8
 */
class DashboardStreamQuery extends ActivityStreamQuery
{
    /**
     * @inheritDoc
     */
    public $pinnedContentSupport = false;

    /**
     * @inheritDoc
     */
    public function beforeApplyFilters()
    {
        parent::beforeApplyFilters();

        if (empty($this->user)) {
            $this->addFilterHandler(Module::getModuleInstance()->guestFilterClass);
        } else {
            $this->addFilterHandler(Yii::createObject([
                'class' => Module::getModuleInstance()->memberFilterClass,
                'user' => $this->user]));
        }
    }

}
