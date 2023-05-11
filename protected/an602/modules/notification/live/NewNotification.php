<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\live;

use an602\modules\live\components\LiveEvent;
use an602\modules\content\models\Content;

/**
 * Live event for new notifications
 *
 * @since 1.2
 */
class NewNotification extends LiveEvent
{

    /**
     * @var int the id of the new notification
     */
    public $notificationId;

    /**
     * @var string related notification group
     */
    public $notificationGroup;
    
    /**
     * @var string text representation used for frotnend desktop notifications 
     */
    public $text;
    
    /**
     * @var int determines if desktop notification has already been sent. 
     */
    public $ts;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->visibility = Content::VISIBILITY_OWNER;
    }

}
