<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\filter\widgets;

class CheckboxListFilterInput extends CheckboxFilterInput
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

    /**
     * @inheritdoc
     */
    public $multiple = true;

    /**
     * @inheritdoc
     */
    public function prepareOptions()
    {
        parent::prepareOptions();
        $this->options['data-action-click'] = $this->clickAction;
        $this->options['data-filter-value'] = $this->value;
    }

}
