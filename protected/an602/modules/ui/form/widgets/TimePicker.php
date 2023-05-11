<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\form\widgets;

use Yii;

/**
 * TimePicker form field widget
 *
 * @inheritdoc
 * @package an602\modules\ui\form\widgets
 */
class TimePicker extends \kartik\time\TimePicker
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->pluginOptions['showMeridian'])) {
            $this->pluginOptions['showMeridian'] = Yii::$app->formatter->isShowMeridiem();
        }

        if (!isset($this->pluginOptions['defaultTime'])) {
            $this->pluginOptions['defaultTime'] = ($this->pluginOptions['showMeridian']) ? '10:00 AM' : '10:00';
        }
    }
}
