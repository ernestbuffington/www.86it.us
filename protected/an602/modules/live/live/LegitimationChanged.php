<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live\live;

use an602\modules\live\components\LiveEvent;
use an602\modules\content\models\Content;

/**
 * Live event for push driver when contentContainerId legitimation was changed
 *
 * @since 1.3
 */
class LegitimationChanged extends LiveEvent
{

    /**
     * @var array the legitimation array
     */
    public $legitimation;

    /**
     * @var int the user id
     */
    public $userId;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->visibility = Content::VISIBILITY_OWNER;
    }

}
