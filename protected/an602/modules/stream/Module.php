<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\stream;

/**
 * Stream Module provides stream (wall) backend and frontend
 *
 * @author Luke
 * @since 1.2
 */
class Module extends \an602\components\Module
{

    /**
     * @var array content classes to excludes from streams
     */
    public $streamExcludes = [];

    /**
     * @var array content classes which are not suppressed when in a row
     */
    public $streamSuppressQueryIgnore = [];

    /**
     * @var array default content classes which are not suppressed when in a row
     */
    public $defaultStreamSuppressQueryIgnore = [
        \an602\modules\post\models\Post::class,
        \an602\modules\activity\models\Activity::class
    ];

    /**
     * @var int number of contents from which "Show more" appears in the stream
     */
    public $streamSuppressLimit = 2;

    /**
     * @var boolean show contents of deactivated users in stream
     */
    public $showDeactivatedUserContent = true;

}
