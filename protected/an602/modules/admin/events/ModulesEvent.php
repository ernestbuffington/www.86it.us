<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\events;

use an602\components\Module;
use yii\base\Event;

/**
 * This event is used when modules is listed and filtered
 *
 * @author luke
 * @since 1.11
 */
class ModulesEvent extends Event
{
    /**
     * @var Module[]|array
     */
    public $modules;
}
