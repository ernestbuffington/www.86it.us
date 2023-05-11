<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\dashboard\widgets;

use an602\modules\activity\widgets\ActivityStreamViewer;
use an602\modules\dashboard\Module;
use an602\widgets\BaseSidebar;
use Yii;

/**
 * Sidebar implements the dashboards sidebar
 */
class Sidebar extends BaseSidebar
{

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        /** @var Module $module */
        $module = Yii::$app->getModule('dashboard');

        if ($module->hideActivitySidebarWidget) {
            foreach ($this->widgets as $k => $widget) {
                if (isset($widget[0]) && ($widget[0] === ActivityStreamViewer::class || $widget[0] === 'an602\modules\activity\widgets\Stream')) {
                    unset($this->widgets[$k]);
                }
            }
        }
    }

}
