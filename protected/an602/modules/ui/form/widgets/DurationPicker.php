<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\form\widgets;

use Yii;
use an602\libs\Html;
use yii\helpers\Json;
use an602\assets\JqueryTimeEntryAsset;
use an602\modules\ui\form\widgets\JsInputWidget;

/**
 * DurationPicker renders an UI form widget to select time durations.
 *
 * @since 1.3
 * @author Luke
 */
class DurationPicker extends JsInputWidget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        $view = $this->getView();
        $id = $this->options['id'];

        $options = [
            'show24Hours' => true,
            'unlimitedHours' => true,
            'defaultTime' => '01:00',
            'timeSteps' => [1, 15],
            'spinnerImage' => ''
        ];

        JqueryTimeEntryAsset::register($view);
        $view->registerJs("$('#{$id}').timeEntry(" . Json::htmlEncode($options) . ");");

        Html::addCssClass($this->options, 'form-control');

        if ($this->model !== null) {
            return Html::activeTextInput($this->model, $this->attribute, $this->getOptions());
        } else {
            return Html::input($this->name, $this->value, $this->getOptions());
        }
    }

    public static function getDuration(\DateTime $start, \DateTime $end)
    {
        $duration = $start->diff($end);
        return $duration->h . ':' . $duration->m;
    }
}
