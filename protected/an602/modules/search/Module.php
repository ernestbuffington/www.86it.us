<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search;

class Module extends \an602\components\Module
{

    public $controllerNamespace = 'an602\modules\search\controllers';

    /**
     * @var int $mentioningSearchBoxResultLimit Maximum results in mentioning users/spaces box
     */
    public $mentioningSearchBoxResultLimit = 6;

}
