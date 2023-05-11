<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\form\interfaces;

/**
 * Interface TabbedFormModel
 * It is related for Model classes only
 *
 * @property-read array $tabs
 *
 * @since 1.11.0
 */
interface TabbedFormModel
{
    /**
     * Initialize tabs for the Form
     *
     * Example of the result:
     * [
     *     [
     *         'label' => 'First tab',
     *         'view' => 'first-tab-view',
     *         'linkOptions' => ['class' => 'first-tab-style'],
     *         'fields' => ['name', 'email', 'password'], // Define all fields from the tab which may have errors after submit in order to make this tab active
     *     ],
     *     [
     *         'label' => 'Second tab',
     *         'view' => 'second-tab-view',
     *         'linkOptions' => ['class' => 'second-tab-style'],
     *         'fields' => ['description', 'tags'],
     *     ],
     * ]
     *
     * @return array
     */
    public function getTabs(): array;
}