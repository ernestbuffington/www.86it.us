<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\stream;

use an602\modules\stream\models\ContentContainerStreamQuery;
use an602\modules\user\models\User;

/**
 * This stream query can be used for streams which support default content as well as activity streams.
 *
 * The behavior of this query can be switching by changing the `activity` flag.
 *
 * @package an602\modules\activity\stream
 * @since 1.8
 */
class ActivityStreamQuery extends ContentContainerStreamQuery
{
    /**
     * @var bool activates or deactivates activity stream behavior
     */
    public $activity = true;

    /**
     * @inheritDoc
     */
    public $pinnedContentSupport = false;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if($this->activity) {
            $this->preventSuppression = true;
        }
    }

    /**
     * @inheritDoc
     */
    public function afterApplyFilters()
    {
        if ($this->activity) {
            $this->channel = self::CHANNEL_ACTIVITY;

            // Note: With the extra null check, the query performs much faster than directly against the status field.
            $this->query()->andWhere(['OR', 'user.id IS NULL', ['!=', 'user.status', User::STATUS_NEED_APPROVAL]])
                ->andWhere(['!=', 'user.visibility', User::VISIBILITY_HIDDEN]);

            // Exclude own activities
            if ($this->user) {
                $this->query()->andWhere('content.created_by != :userId', [':userId' => $this->user->id]);
            }
        }
        parent::afterApplyFilters();
    }
}
