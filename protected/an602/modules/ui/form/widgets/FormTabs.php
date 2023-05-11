<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\form\widgets;

use an602\modules\ui\form\interfaces\TabbedFormModel;
use an602\widgets\Tabs;
use yii\base\Model;

/**
 * Class TabsForm
 *
 * @since 1.11.0
 */
class FormTabs extends Tabs
{

    /**
     * @var TabbedFormModel
     */
    public $form;

    /**
     * @inheritdoc
     */
    protected function beforeSortItems()
    {
        $this->initTabbedFormItems();

        parent::beforeSortItems();
    }

    private function initTabbedFormItems()
    {
        if (!($this->form instanceof TabbedFormModel && $this->form instanceof Model)) {
            return;
        }

        $items = $this->form->tabs;
        if (empty($items)) {
            return;
        }

        $this->items = $items;

        if (!$this->form->hasErrors()) {
            return;
        }

        // Find first error with field and activate that tab
        $errorFields = array_keys($this->form->getErrors());
        foreach ($this->items as $t => $tab) {
            if (!empty(array_intersect($tab['fields'], $errorFields))) {
                $this->items[$t]['active'] = true;
                // Stop on first found error
                return;
            }
        }
    }
}