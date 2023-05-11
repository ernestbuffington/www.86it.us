<?php


namespace an602\modules\user\stream;

use an602\modules\stream\actions\ContentContainerStream;
use an602\modules\stream\models\filters\ContentContainerStreamFilter;
use an602\modules\stream\models\WallStreamQuery;
use an602\modules\user\models\User;
use an602\modules\user\stream\filters\IncludeAllContributionsFilter;
use an602\modules\stream\models\ContentContainerStreamQuery;

/**
 * ProfileStream
 *
 * @package an602\modules\user\components
 */
class ProfileStreamQuery extends ContentContainerStreamQuery
{

    /**
     * @var bool|null can be used to set a default state for the IncludeAllContributionsFilter
     */
    public $includeContributions;

    /**
     * @inheritdoc
     */
    public function beforeApplyFilters()
    {
        parent::beforeApplyFilters();
        $this->removeFilterHandler(ContentContainerStreamFilter::class);

        // The default scope may be overwritten by first request, the real default is handled in the stream filter navigation
        $this->addFilterHandler(new IncludeAllContributionsFilter([
            'container' => $this->container,
            'scope' => $this->includeContributions
                ? IncludeAllContributionsFilter::SCOPE_ALL
                : IncludeAllContributionsFilter::SCOPE_PROFILE
        ]));
    }
}
