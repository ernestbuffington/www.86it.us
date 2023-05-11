<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\filter\widgets;

use Yii;
use yii\helpers\ArrayHelper;

class CheckboxFilterInput extends FilterInput
{
    /**
     * @inheritdoc
     */
    public $view = 'checkboxInput';

    /**
     * @inheritdoc
     */
    public $type = 'checkbox';

    /**
     * @var string data-action-click handler of the input event
     */
    public $clickAction = 'toggleFilter';

    public $iconActive = 'fa-check-square-o';

    public $iconInActive = 'fa-square-o';

    public $checked = false;

    /**
     * @inheritdoc
     */
    protected function initFromRequest()
    {
        $filters = Yii::$app->request->get($this->category);
        if (!empty($filters[$this->id])) {
            $this->checked = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function prepareOptions()
    {
        parent::prepareOptions();
        $this->options['data-action-click'] = $this->clickAction;
        $this->options['data-filter-value'] = $this->value;
        $this->options['data-filter-icon-active'] = $this->iconActive;
        $this->options['data-filter-icon-inactive'] = $this->iconInActive;
        $this->options['href'] = '#';
    }

    /**
     * @inheritdoc
     */
    protected function getWidgetOptions()
    {
        return ArrayHelper::merge(parent::getWidgetOptions(), [
            'checked' => $this->checked,
            'iconActive' => $this->iconActive,
            'iconInActive' => $this->iconInActive
        ]);
    }

}
