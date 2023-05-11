<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\filter\widgets;

use an602\modules\ui\filter\widgets\FilterInput;
use an602\libs\Html;

/**
 * Dropdown stream filter input type.
 * 
 * @since 1.6
 * @package an602\modules\ui\filter\widgets
 */
class DropdownFilterInput extends FilterInput
{
    /**
     * @inheritdoc
     */
    public $view = 'dropdownInput';

    /**
     * @inheritdoc
     */
    public $type = 'dropdown';

    /**
     * @var array dropdown selection
     */
    public $selection = [];

    /**
     * @var array dropdown items
     */
    public $items = [];

    /**
     * @inheritdoc
     */
    public function prepareOptions()
    {
        parent::prepareOptions();
        $this->options['data-action-change'] = 'inputChange';
        Html::addCssClass($this->options, 'form-control');
    }

    /**
     * @inheritdoc
     */
    protected function getWidgetOptions()
    {
        return array_merge(parent::getWidgetOptions(), [
            'selection' => $this->selection,
            'items' => $this->items
        ]);
    }
}
